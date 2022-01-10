<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItems extends Controller
{
    
    public static function storeOrderItems(array $items, int $orderId)
    {
        foreach ($items as $id => $product) {
            
            OrderItem::create([
                'price' => $product['price'],
                'order_id' => $orderId,
                'pro_id' =>$id
            ]);
        } 
    }
}
