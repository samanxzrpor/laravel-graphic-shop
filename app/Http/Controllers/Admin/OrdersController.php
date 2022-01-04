<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    
    public function showAll()
    {
        $orders = Order::paginate(10);

        return view('admin.orders' , ['orders' => $orders]);
    }

}
