<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Cart extends Controller
{

    public $time = 600;
 

    public function add($product_id)
    {
        $product = Product::findOrFail($product_id);

        $cart = json_decode(Cookie::get('cart') , true);

        if (!$cart) {

            $cart = [
                $product_id => [
                    'id' => $product_id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'thumbnail' => $product->thumbnail_url,
                ],
            ];
    
            $cart = json_encode($cart);

            Cookie::queue('cart' , $cart , $this->time);

            return back()->with('success' , 'محصول به سبد خرید اضافه شد');
        }
        
        if (isset($cart[$product_id]))
            return back()->with('success' , 'محصول به سبد خرید اضافه شد');

        $cart [$product_id] = [
            'id' => $product_id,
            'title' => $product->title,
            'price' => $product->price,
            'thumbnail' => $product->thumbnail_url,
        ];

        $cart = json_encode($cart);

        Cookie::queue('cart' , $cart , $this->time);

        return back()->with('success' , 'محصول به سبد خرید اضافه شد');
        
    }
    
    public static function showAll()
    {
        return json_decode(Cookie::get('cart') , true) ?? [];
    }
    
    public static function getCountCart()
    {
        $items = json_decode(Cookie::get('cart'), true) ;

        if ($items)
            return count($items);

        return 0;
    }

    public static function getAmountCart()
    {
        $items = json_decode(Cookie::get('cart'), true) ;
        
        if ($items)
            return array_sum(array_column($items , 'price'));

        return 0;
    }

    public function delete($product_id)
    {
        $cart = json_decode(Cookie::get('cart'), true);

        if (array_key_exists($product_id, $cart)){

            unset($cart[$product_id]);

            Cookie::queue('cart' , json_encode($cart) , $this->time);

            return back()->with('success' , 'محصول از سبد خرید حذف شد');
        }
    }
}
