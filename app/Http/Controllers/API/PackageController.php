<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Package;
use App\Package_Details;
use App\Product;
class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $fileName = "";
    public function index()
    {
        return Product::where('category_id', 2)->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        $box = 0;
        $this->validate($request,[
            'package_name' => 'required',
            'discount' => 'required',
            'total_box' => 'required',
            'quantity' => 'required',
          
        ]);

        if($request->imageData != "" || !empty($request->imageData || !is_null($request->imageData)) || $request->imageData != "img/picture.png"){
            $imageData = $request->imageData;
            $fileName = \Carbon\Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            $img = \Image::make($imageData)->fit(380, 380);
            $img->stream();
            \Storage::disk('local')->put('public/package-images'.'/'.$fileName, $img, 'public');
            $this->fileName = $fileName;
        }
        $request['image'] = $fileName;
        foreach($request->listItems as $listItems){
            $box = $box + $listItems['box'];
        }
        $request['total_box'] = $box;
        $package = Package::create($request->only(['package_name','discount','total_box','quantity','total_price', 'image']));
        
        foreach($request->listItems as $listItems){
           
            $package->package_details()->create([
                'product_id' => $listItems['id'],
                'quantity' => $listItems['quantity'],
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Package_Details::with('products')->where('package_id', $id)->get();
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
}
