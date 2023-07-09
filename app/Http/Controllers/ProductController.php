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
        $thumbnail = $request->file('thumbnail');
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
    //edit
    public function edit($id)
    {
        $product_info = Product::where('id', $id)->first();
        return view('edit', compact('product_info'));
    }
    //update
    public function update(Request $request, $id)
    {
        //update thumbnail image
        if (isset($request->thumbnail)) {
            $old_thumbnail = $request->old_thumbnail;

            $updated_thumbnail_image = $request->thumbnail;
            $updated_thumbnail_image_name = time() . '.' . $updated_thumbnail_image->getClientOriginalExtension();
            $updated_thumbnail_image->move(public_path('assets/images/product-images/thumbnail'), $updated_thumbnail_image_name);

            unlink(public_path('assets/images/product-images/thumbnail/') . $old_thumbnail);

            Product::where('id', $id)->update([
                'thumbnail' => $updated_thumbnail_image_name,
            ]);
        }
        Product::where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        //update multiple images
        if(isset($request->image)){
            $update_multiple_images = $request->image;

            foreach ($update_multiple_images as $single_image) {
                $single_image_name = uniqid() . '.' . $single_image->getClientOriginalExtension();
                $single_image->move(public_path('assets/images/product-images/multiple-images'), $single_image_name);


                $product = new Product;
                $temporary_image = new TemporaryImage;
                $temporary_image->product_id = $id;
                $temporary_image->image = $single_image_name;
                $temporary_image->save();
            }
        }
        return redirect()->route('index')->with('success', 'updated');
    }
    // destroyThumbnail
    public function destroyThumbnail($multi_image_id)
    {
        $image_name = TemporaryImage::where('id', $multi_image_id)->first()->image;

        TemporaryImage::destroy($multi_image_id);
        unlink(public_path('assets/images/product-images/multiple-images/') . $image_name);

        return redirect()->back()->with('destroy', 'an image has been deleted from multiple image of this product');
    }
}
