<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Package;
use App\Category;
use App\Package_Details;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $box = 0;
    private $fileName = '';
    public function index()
    {
        if(isset($_GET['listProduct'])){
            return Category::with('product')->get();
        }else{
            return Product::latest()->paginate(10);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // dd($request->listItems);
        $this->validate($request,[
            'package_name' => 'required',
        ]);

        $category = Category::find($request->type);
        
        if($category->name == 'Package'){
            $request['price'] = $request->total_price;
            $request['item'] = $request->package_name;

            foreach($request->listItems as $listItems){
                $this->box = $this->box + $listItems['box'];
            }
            $request['box'] = $this->box;
            $request['supplier'] = 0;
            if($request->imageData != "img/picture.png"){
                $imageData = $request->imageData;
                $fileName = \Carbon\Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                $img = \Image::make($imageData)->fit(380, 380);
                $img->stream();
                \Storage::disk('local')->put('public/package-images'.'/'.$fileName, $img, 'public');
                $this->fileName = $fileName;
            }
            $request['photo'] = $this->fileName;
        }else{
            if(!isset($request->photo)){
                $name = 'picture.png';
            }
            if($request->photo){
                $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
    
                \Image::make($request->photo)->save(public_path('img/product/').$name);
            }
            $request['photo'] = $name;
        }
        $product = $category->product()->create($request->only(['item','supplier','price','discount', 'quantity','photo','box']));
        
        foreach($request->listItems as $listItems){
            Package_Details::create([
                'package_id' => $product->id,
                'product_id' => $listItems['id'],
                'quantity' => $listItems['quantity'],
            ]);
        }
        // $this->validate($request, [
        //     'item' => 'required',
        //     'price' => 'required',
        //     'quantity' => 'required',
        //     'supplier' => 'required'
        // ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
       
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
        // dd($request->all());
        $this->validate($request, [
            'item' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);
        $product = Product::find($id);
        if($request->photo == $product->photo){
            $name = $request->photo;
        }else{
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/product/').$name);
        }
        $request['photo'] = $name;
        $product->update($request->only(['item','price','quantity','photo','box']));
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

    public function lowStock(){
        return Product::where('quantity','<=','5')->get();
    }

    public function deleteProduct(Request $request){
        Product::find($request->product_id)->delete();
    }

    public function recent(){
        return Product::latest()->paginate(3);
    }
}
