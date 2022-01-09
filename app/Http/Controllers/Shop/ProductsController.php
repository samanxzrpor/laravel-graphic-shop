<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    
    public function showAll(Request $request)
    {
        $products = Product::paginate(15);
        
        if (isset($request->filter , $request->action))
            $products = $this->filterProducts($request->input('filter') , $request->input('action') ,$request->input('value')) 
            ?? Product::paginate(15);

        if ($request->has('search')) 
            $products = Product::where('title' , 'LIKE' ,'%' . $request->input('search') . '%')->paginate(15);

        if ($request->has('search-product')) 
            $products = Product::where('title' , 'LIKE' ,'%' . $request->input('search-product') . '%')->paginate(15);

        $categories = Category::all();

        return view('frontend.index' , ['products' => $products, 'categories' => $categories , 'carts' => Cart::showAll()]);
    }

    public function single(int $product_id)
    {
        $product = Product::findOrFail($product_id);

        $relatedProducts = Product::where('category_id' , '=' , $product['category_id'])
        ->where('id', '<>', $product['id'])
        ->take(4)
        ->get();

        return view('frontend.single', ['product' => $product , 'relatedProducts'=>$relatedProducts, 'carts'=>Cart::showAll()]);
    }

    private function filterProducts (string $filter ,string $action , string|null $value)
    {
        $products = [];

        $baseNamespace = '\App\Http\Controllers\Filters\\';

        $className = $baseNamespace . ucfirst($filter);
        
        if (class_exists($className))
            return null;

        $object = new $className();
        
        if (!method_exists($object, $action))
            return null;
    
        $products = $object->{$action}($value);

        return $products;
    }
}
