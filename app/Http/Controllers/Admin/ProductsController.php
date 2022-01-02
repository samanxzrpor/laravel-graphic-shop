<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StorePro;
use App\Models\Category;
use App\Models\Product;
use App\Utilities\Remover;
use App\Utilities\Uploader;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{


    public function showAll ()
    {
        $products = Product::paginate(10);

        return view('admin.products' , ['products' => $products]);
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
            return back()->with('failed' , $e->getMessage());
        }
        # Update Product Column for save image Path
        $newProduct->update([
            'thumbnail_url'=> $imagesPath['thumbnail_url'],
            'demo_url'=> $imagesPath['demo_url'],
            'source_url'=> $sourcePath
        ]);

        return back()->with('success' , 'محصول جدید ایجاد شد');
    }

    public function downloadDemo(int $product_id)
    {
        $product = Product::findOrFail($product_id);

        return response()->download(public_path('/uploads/' . $product->demo_url));
    }

    public function downloadSource(int $product_id)
    {
        $product = Product::findOrFail($product_id);

        return response()->download(storage_path('app/uploads/' .$product->source_url));
    }

    public function delete(int $product_id)
    {
        $productToDelete = Product::find($product_id);

        Remover::deleteAll([
            public_path('/uploads/products/'.$productToDelete->id),
            storage_path('app/uploads/products/'.$productToDelete->id),
        ]);
            
        $productToDelete->delete();

        return back()->with('success' ,'محصول حذف شد');
    }

}
