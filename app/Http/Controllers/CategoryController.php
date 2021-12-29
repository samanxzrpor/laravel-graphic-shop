<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    public function showNewCategory()
    {
        return view('admin.add-category');
    }
}
