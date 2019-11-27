<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AddToCart;
use App\Order;
use App\Product;
use App\OrderDetails;
use App\Customer;
use App\OrderPackageDetails;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
    
        $request['term'] = 2;
        $request['salesMan'] = 'Jeric';
        $request['selectedPack'] = 'karton';
        $request['selectedUnit'] = 'box';    
        $addToCart = AddToCart::with(['product' => function($query){
            return $query->with(['packageDetails' => function($query){
                return $query->with('products');
            } ]);
        }])->where('customer_id',$request->customer_id)->get();
        
        
        foreach ($addToCart as $value) {
            foreach($value->product->packageDetails as $details){
                OrderPackageDetails::create([
                    'package_id' => $details->package_id,
                    'product_id' => $details->product_id,
                    'quantity' => $details->quantity,
                ]);
            }
        }
       
        $cart = AddToCart::where('customer_id',$request->customer_id)->get();
        $order = Order::create([
            'user_id' => $request->user_id,
            'customer_id' => $request->customer_id,
            'price' => $request->total,
            'term' => $request->term,
            'sales_man' => $request->salesMan,
            'unit' => $request->selectedUnit,
            'pack' =>$request->selectedPack,
            'kart_quantity' => $request->noOfKarton,
            'status' => 'delivery',
        ]);
        $i = 1;
        foreach($cart as $checkOut){
            $order->orderDetails()->create([
                'product_id' => $checkOut->product_id,
                'quantity' => $checkOut->quantity,
                'price' => $checkOut->product->price
            ]);
                if($checkOut->product->type != "package"){
                    Product::find($checkOut->product->id)->update([
                            'quantity' => $checkOut->product->quantity - $checkOut->quantity
                    ]);
                }else{
                   
                    
                    foreach ($addToCart as  $value) {
                        
                        foreach ($value->product->packageDetails as  $item) {
                            $updateProduct = Product::where('id', $item->product_id)->first();
                            $updateProduct->quantity = $updateProduct->quantity - ($item->quantity * $value->quantity);
                            $updateProduct->save();
                        } 
                    }
                    if($i++ == 1) break;
                }
               
            
            AddToCart::find($checkOut->id)->delete();
        }

        $this->deductCredit($request->customer_id, $request->total);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::with('orderDetails.product')->where('customer_id',$id)->orderBy('id','DESC')->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reorder(Request $request){
        $order = Order::with('orderDetails.product')->find($request->order_id);
        
        $newOrder = Order::create([
            'customer_id' => $order->customer_id,
            'status' => 0,
            'price' => $order->price
        ]);

        foreach($order->orderDetails as $product){
            $newOrder->orderDetails()->create([
                'product_id' => $product->product_id,
                'quantity' => $product->quantity,
                'price' => $product->price 
            ]);
            
            Product::find($product->product->id)->update([
                'quantity' => $product->product->quantity - $product->quantity
            ]);
            
        }
    }

    public function orderList(Request $request){
        $status = $request->status;
        
        if($status == 'all'){
            return Order::with('customer')->where('user_id',$request->user_id)->get();
        }else{
            return Order::with('customer')->where('user_id',$request->user_id)->where('status', $status)->get();
        }
    }

    public function viewOrderDetails(Request $request){
        
        $order = Order::with(['user','customer', 'orderDetails' => function($query){
            return $query->with(['product' => function($query){
                return $query->with('orderPackageDetails.products');
            }]);
        }])
        ->find($request->order_id);
        
        $inv = str_pad($order->id, 8, '0', STR_PAD_LEFT);
        $split = str_split($inv, 4);
    
        $orNumber = $split[0] . "-" . $split[1];

        return response()->json([
            'orders' => $order,
            'OR' => $orNumber
        ]);
    }

    public function deleteItem(Request $request){
        AddToCart::find($request->id)->delete();
    }


    private function deductCredit($customerId, $total){
        $customer = Customer::find($customerId);
        $customer->balance = $customer->balance - $total;
        $customer->save();
    }
}
