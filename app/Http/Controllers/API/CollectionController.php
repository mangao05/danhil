<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Collection;
use App\Order;
class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $status;
    public function index()
    {
        return Collection::with('order.customer')->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // find or first  => return relationship
        // get or all => with() call the relationship
        $order = Order::find($request->order_id);
       
        
        if($request->payment_type == 'Cash'){
            if($order->price  <= $request->value){
                $order->customer()->update([
                    'balance' => $order->customer->balance + $order->price
                ]);
                
                
                $this->status = 'paid';
               
            }else{
                $this->status = 'unpaid';
            }
        }
        
        $order->collection()->create($request->all());
        $order->update([
            'status' => $this->status
        ]);

        return "success";

        
        

        // return "Success";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function collection(Request $request){
        // if($request->payment_type == '3'){
        //     return Collection::with('order.customer')->where('payment_type','Cash')->latest()->paginate(10);            
        // }else{
            return Collection::with('order.customer')->where('check_type',$request->check_type)->latest()->paginate(10);
        // }
    }
}
