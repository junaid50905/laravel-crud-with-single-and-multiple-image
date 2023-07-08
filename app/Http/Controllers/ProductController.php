<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TemporaryImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //index
    public function index()
    {
        $products = Product::all();
        return view('welcome', compact('products'));
    }
    //create
    public function create()
    {
        return view('create');
    }
    //store
    public function store(Request $request)
    {
        $thumbnail = $request->thumbnail;
        $thumbnail_name = time() . '.' . $thumbnail->getClientOriginalExtension();
        $thumbnail->move(public_path('assets/images/product-images/thumbnail'), $thumbnail_name);

        // Create a new product
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->thumbnail = $thumbnail_name;
        $product->save();

        // Create a new phone associated with the user
        $multiple_images = $request->image;
        foreach ($multiple_images as $single_image) {
            $single_image_name = uniqid() . '.' . $single_image->getClientOriginalExtension();
            $single_image->move(public_path('assets/images/product-images/multiple-images'), $single_image_name);

            $temporary_image = new TemporaryImage;
            $temporary_image->product_id = $product->id;
            $temporary_image->image = $single_image_name;
            $temporary_image->save();
        }

        return redirect()->route('index')->with('success', 'product added successfully');

    }
    //destroy
    public function destroy($id)
    {
        $thumbnail = Product::where('id', $id)->first()->thumbnail;
        $multiple_images = TemporaryImage::where('product_id', $id)->get();


        Product::destroy($id);
        unlink(public_path('assets/images/product-images/thumbnail/').$thumbnail);
        foreach ($multiple_images as $image) {
            $image_path = public_path('assets/images/product-images/multiple-images/') . $image->image;
            if (file_exists($image_path)) {
                // Unlink the image file
                unlink($image_path);
            }
        }
        return redirect()->back();
    }
}
