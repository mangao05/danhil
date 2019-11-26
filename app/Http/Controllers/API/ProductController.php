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
    
    private $fileName = '';
    public function index()
    {
        if(isset($_GET['listProduct'])){
            return Category::with('product')->get();
        }else{
            $filter = $_GET['filter'];
            if(isset($filter)){
                return Product::where('item','like','%'.$filter.'%')->
                                where('type','item')->latest()->paginate(8);
            }else{
                return Product::where('type','item')->latest()->paginate(8);
            }
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
       

        $category = Category::find($request->type);
        
        if($category->name == 'Package'){
            $request['price'] = $request->total_price;
            $request['item'] = $request->package_name;
            $request['type'] = "package";

            $request['supplier'] = 0;
            if($request->imageData != "img/picture.png"){
                $imageData = $request->imageData;
                $fileName = \Carbon\Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                $img = \Image::make($imageData)->fit(380, 380);
                $img->stream();
                \Storage::disk('local')->put('public/package-images'.'/'.$fileName, $img, 'public');
                $this->fileName = $fileName;
                $request['photo'] = $this->fileName;
            }
            if(!isset($request->photo)){
                $request['photo'] = "picture.png";
            }
            
        }else{

            if(!isset($request->photo)){
                $name = 'picture.png';
            }
            if($request->photo){
                $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
    
                \Image::make($request->photo)->save(public_path('img/product/').$name);
            }
            $request['photo'] = $name;
            $request['type'] = "item";
        }


        $product = $category->product()->create($request->only(['item','supplier','price','discount', 'quantity','photo','type']));
        
        if($category->name == 'Package'){
            foreach($request->listItems as $listItems){
                Package_Details::create([
                    'package_id' => $product->id,
                    'product_id' => $listItems['id'],
                    'quantity' => $listItems['quantity'],
                ]);
            }
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
        return Product::with('packageDetails.products')->find($id);
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
        $product->update($request->only(['item','price','quantity','photo']));
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
        return count(Product::where('quantity','<=','5')
                            ->where('type','item')->get());
    }

    public function deleteProduct(Request $request){
        Product::find($request->product_id)->delete();
       

        $roomPhoto = public_path('/storage/package-images/').$request->photo;
        if(File_exists($roomPhoto)){
            @unlink($roomPhoto);
        }
    }

    public function recent(){
        return Product::latest()->paginate(3);
    }

    public function search_filter(Request $request){
        return Product::where('item','like','%'.$request->keyword.'%')->
                        where('type','item')->latest()->paginate(8);
    }

    public function add_quantity(Request $request){
        $item = Product::find($request->id);
        $item->update([
            'quantity' => $item->quantity + $request->quantity
        ]);
        return "success";
    }

    public function currentVsList(Request $request){
        $id = $request->id;
        // \DB::enableQueryLog();
        //     $packages_id =  Package_Details::select('product_id')->where('package_id', $id)->get();
            // Product::with('packageDetails')->whereNotIn('id', $packages_id)->where('type', 'item')->get();
            return Product::with('packageDetails')->whereNotIn('id', function($query) use ($id){
                    return $query->select('product_id')
                                ->from('package__details')
                                ->where('package_id', $id);
                })->where('type', 'item')->get();
        // dd(\DB::getQueryLog());

        //

    }

}
