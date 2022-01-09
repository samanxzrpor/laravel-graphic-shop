<?php
namespace App\Http\Controllers\Filters;

use App\Models\Product;

class Orderby
{

    public function default()
    {
        $products = Product::orderby('created_at' , 'asc')->paginate(15);

        return $products;
    }

    public function papular()
    {
        $products = Product::orderby('created_at' , 'desc')->paginate(15);

        return $products;
    }

    public function newest()
    {
        $products = Product::orderby('created_at' , 'desc')->paginate(15);

        return $products;
    }

    public function highToLow()
    {
        $products = Product::orderby('price','desc')->paginate(15);

        return $products;
    }
    
    public function lowToHigh()
    {
        $products = Product::orderby('price','asc')->paginate(15);

        return $products;
    }

}