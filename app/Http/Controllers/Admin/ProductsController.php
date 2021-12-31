<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StorePro;
use App\Models\Category;
use App\Models\Product;
use App\Utilities\Uploader;
use Illuminate\Http\Request;


class ProductsController extends Controller
{
    //

    public function showAll ()
    {
        return view('admin.products');
    }


    public function showCreatePage ()
    {
        $listOfCat = Category::all();
        
        
        return view('admin.add-product' , [
            'listOfCat' => $listOfCat
        ]);
    }

    public function addProduct (StorePro $request)
    {
        # validate Data 
        $dataForStore = $request->validated();

        # store Data of Product in Database
        $newProduct = Product::create([
            'title' =>$dataForStore['title'],
            'price' =>$dataForStore['price'],
            'description' =>$dataForStore['description'],
            'category_id' =>$dataForStore['category_id'],
            'user_id' => 1
        ]);

        try {
            # Store Publicly images
            $publiclyImages = ['thumbnail_url'=> $dataForStore['thumbnail_url'], 'demo_url'=>$dataForStore['demo_url']];
            $publiclyPath = 'products/' . $newProduct->id . '/';
            $imagesPath = Uploader::all($publiclyImages ,$publiclyPath);

            # Store source image 
            $sourcePath = 'products/' . $newProduct->id . '/source_url_' . $dataForStore['source_url']->getClientOriginalName();
            Uploader::one($dataForStore['source_url'] ,$sourcePath ,'local_storage');

        } catch (\Exception $e) {
            return back()->with('fatal' , $e->getMessage());
        }
        # Update Product Column for save image Path
        $newProduct->update([
            'thumbnail_url'=> $imagesPath['thumbnail_url'],
            'demo_url'=> $imagesPath['demo_url'],
            'source_url'=> $sourcePath
        ]);

        return back()->with('success' , 'محصول جدید ایجاد شد');
    }
}
