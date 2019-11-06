<?php 
namespace App\Http\Traits;

trait ImageTrait {

    public static function createImage($photo, $products){
        if($photo != '/img/product-images/happy_image.png'){
            $imageData = $photo;
            $fileName = \Carbon\Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            $img = \Image::make($imageData)->fit(380, 380);
            $img->stream();
            \Storage::disk('local')->put('public/product-images'.'/'.$fileName, $img, 'public');
            $products->product_images()->create(['image' => $fileName, 'is_main' => true]);
        }
    }
}