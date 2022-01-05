<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    
    public function showAll(Request $request)
    {
        $products = Product::paginate(15);
        
        if ($request->has('filter') && $request->has('action'))
            $products = $this->filterProducts($request->input('filter') , $request->input('action') ,$request->input('value'));

        if ($request->has('search')) 
            $products = Product::where('title' , 'LIKE' ,'%' . $request->input('search') . '%')->paginate(15);

        if ($request->has('search-product')) 
            $products = Product::where('title' , 'LIKE' ,'%' . $request->input('search-product') . '%')->paginate(15);

        $categories = Category::all();

        return view('frontend.index' , ['products' => $products, 'categories' => $categories]);
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

    private function filterProducts (string $filter ,string $action , string|null $value)
    {
        $products = [];

        $baseNamespace = '\App\Http\Controllers\Filters\\';

        $className = $baseNamespace . ucfirst($filter);
        
        if (class_exists($className))
            $object = new $className();

        if (method_exists($object, $action))
            $products = $object->{$action}($value);

        return $products;
    }
}
