<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AddToCart;
use App\Customer;
use App\Product;
use App\Package;

class AddToCartController extends Controller
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
            $box = Product::find($request->product_id)->box; 

            $request['total_box'] = $box * $request->quantity;

            AddToCart::updateOrCreate(
                [
                    'product_id' => $request->product_id,
                    'customer_id' => $request->customer_id
                ],
                $request->only(
                [
                    'customer_id','product_id','quantity','total_box'
                ])
            );
             
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        if(request()->has('cartPreview')){
            $cart =  AddToCart::with(['product' => function($query){
                return $query->with(['packageDetails' => function($query){
                    return $query->with('products');
                }]);
            }], 'customer')->where('customer_id',$id)->get();

            return $cart ;
        }else{
            return count(AddToCart::where('customer_id',$id)->get());
        }
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

    public function displayCheckCart(Request $request){
        return AddToCart::with('product')->whereIn('id',$request->cartIDS)->get();
    }

    public function cartDetailsCustomer(Request $request){
        return Customer::find($request->customer_id);
    }

    public function grandTotal(Request $request){
        return AddToCart::with('product')->where('customer_id',$request->customer_id)->get();
    }

    public function totalKarton(Request $request){
        return AddToCart::where('customer_id',$request->customer_id)->sum('total_box');
    }
}
