<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    
    public function showAll()
    {
        $products = Product::paginate(15);

        return view('frontend.index' , ['products' => $products]);
    }

    public function single(int $product_id)
    {
        $product = Product::findOrFail($product_id);

        $relatedProducts = Product::where('category_id' , '=' , $product['category_id'])
        ->where('id', '<>', $product['id'])
        ->take(4)
        ->get();

        return view('frontend.single', ['product' => $product , 'relatedProducts'=>$relatedProducts]);
    }
}
