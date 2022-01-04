<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StorePro;
use App\Http\Requests\Admin\Products\UpdatePro;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Utilities\Remover;
use App\Utilities\Uploader;
use Illuminate\Http\Request;
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

    public function storeProduct (StorePro $request)
    {
        # validate Data 
        $dataForStore = $request->validated();

        $user = User::where('role', 'admin')->first();

        # store Data of Product in Database
        $newProduct = Product::create([
            'title' =>$dataForStore['title'],
            'price' =>$dataForStore['price'],
            'description' =>$dataForStore['description'],
            'category_id' =>$dataForStore['category_id'],
            'user_id' => $user['id']
        ]);

        $this->uploadAndUpdateFiles($dataForStore , $newProduct);

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

    public function edit(int $product_id)
    {
        $productData = Product::findOrFail($product_id);

        $listOfCat = Category::all();

        return view('admin.up-product' , ['product'=>$productData , 'listOfCat' => $listOfCat]);
    }

    public function update(UpdatePro $request ,int $product_id)
    {  
        $dateForUpdate = $request->validated();
       
        $productToUpdate = Product::findOrFail($product_id);

        $productToUpdate->update([
            'title' => $dateForUpdate['title'],
            'description' => $dateForUpdate['description'],
            'price' => $dateForUpdate['price'],
            'category_id' => $dateForUpdate['category_id']
        ]);

        if (isset($dateForUpdate['thumbnail_url'])) 
            File::delete(public_path('/uploads/'. $productToUpdate['thumbnail_url']));
        
        if (isset($dateForUpdate['demo_url'])) 
            File::delete(public_path('/uploads/'. $productToUpdate['demo_url']));

        if (isset($dateForUpdate['source_url'])) 
            File::delete(storage_path('/app/uploads/'. $productToUpdate['thumbnail_url']));
        
        
        $this->uploadAndUpdateFiles($dateForUpdate , $productToUpdate);

        return back()->with('success', 'محصول مورد نظر بروزرسانی شد');
    }


    private function uploadAndUpdateFiles(array $dateForUpdate , mixed $product)
    {
        $basePath = 'products/' . $product->id . '/';

        foreach ($dateForUpdate as $key => $value) {
            
            if (strpos($key ,'url')) {

                if (!is_null($value)) {

                    $basePath .= $key . '_' . $value->getClientOriginalName();

                    if ($key == 'source_url') {

                        Uploader::one($value ,$basePath ,'local_storage');
                    }

                    Uploader::one($value ,$basePath);

                    $product->update([$key => $basePath]);
                }
            }
        }
    }
}
