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
        $allCategories = Category::paginate(10);

        return view('admin.categories' ,['allCategories' => $allCategories]);
    }

    public function showCreatePage()
    {
        return view('admin.add-category');        
    }

    public function showUpdatePage(int $cat_id)
    {
        $categoryData = Category::find($cat_id);
 
        return view('admin.up-category' , ['categoryData' => $categoryData]);        
    }

    public function store(StoreCat $request)
    {
        $receivedData =  $request->validated();

        Category::create(['slug' => $receivedData['slug'], 'title' => $receivedData['title']]);

        return back()->with('success' , 'دسته جدید ایجاد شد');
    }

    public function delete(int $cat_id)
    {
        Category::find($cat_id)->delete();

        return back();
    }

    public function update(int $cat_id ,Request $request)
    {
        $dataForUpdate = $request->validate([
            'title' => 'required|min:3|max:128',
            'slug' => 'required|min:3|max:128',
        ]);

        Category::find($cat_id)->update(['title'=>$dataForUpdate['title'] , 'slug'=>$dataForUpdate['slug']]);

        return back()->with('success' , 'دسته مورد نظر برروزرسانی شد');
    }

}
