<?php
namespace App\Http\Controllers\Filters;

use App\Models\Product;

class Price
{

    public function set(string $value)
    {
        $limit = explode('-' , $value);

        $products = Product::whereBetween('price' , [$limit[0] , $limit[1]])->paginate(15);

        return $products;
    }

}