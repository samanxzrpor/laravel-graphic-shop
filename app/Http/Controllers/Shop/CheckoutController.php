<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    
    public function show()
    {
        return view('frontend.checkout' , ['carts' => Cart::showAll()]);
    }
}
