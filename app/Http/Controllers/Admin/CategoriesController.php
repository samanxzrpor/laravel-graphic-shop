<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreCat;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    //

    public function showAll()
    {
        $allCategories = Category::all();

        return view('admin.categories' ,['allCategories' => $allCategories]);
    }

    public function showCreatePage()
    {
        return view('admin.add-category');        
    }

    public function store(StoreCat $request)
    {
        $receivedData =  $request->validated();

        Category::create(['slug' => $receivedData['slug'], 'title' => $receivedData['title']]);

        return back()->with('success' , 'دسته جدید ایجاد شد');
    }

    public function delete(Request $request)
    {
        $deletedID = $request['dlt-id'];

        Category::find($deletedID)->delete();

        return back();
    }

}
