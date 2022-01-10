<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class Orders extends Controller
{
   
    public static function createOrder(array $data)
    {
        $newOrder = Order::create([
            'amount' => $data['amount'],
            'user_id' => $data['user_id'],
            'ref_code'=> $data['ref_code']
        ]);

        return $newOrder;
    }

}
