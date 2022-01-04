<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreUser;
use App\Http\Requests\Admin\Users\UpdateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    
    public function showAll()
    {
        $users = User::paginate(10);

        return view('admin.users' , [
            'users' => $users
        ]);
    }

    public function showCreatePage()
    {   
        $roles = User::getUsersRoles();

        return view('admin.add-user' , [
            'roles' => $roles
        ]);
    }

    public function storeUser(StoreUser $request)
    {
        $dataForStore = $request->validated();
        
        try {
            $storedUser = User::create([
                'name' => $dataForStore['name'],
                'email' => $dataForStore['email'],
                'role' => strval($dataForStore['role']),
                'number' => $dataForStore['number'],
                'password' => Hash::make($dataForStore['password'])
            ]);

        } catch (\Exception $e) {

            return back()->with('failed' , $e->getMessage());
        }

        return back()->with('success' , 'کاربر جدید ایجاد شد');
    }

    public function edit(int $user_id)
    {
        $userForUpdate = User::findOrFail($user_id);

        $roles = User::getUsersRoles();

        return view('admin.up-user' , ['user' => $userForUpdate ,'roles' => $roles]);
    }

    public function update(UpdateUser $request , $user_id)
    {
        $dateForUpdate = $request->validated();

        $userForUpdate = User::findOrFail($user_id);

        $password = !is_null($dateForUpdate['password']) ? Hash::make($dateForUpdate['password']) : $userForUpdate['password']; 

        try {
            $userForUpdate->update([
                'name' => $dateForUpdate['name'],
                'password' => $password,
                'role' => $dateForUpdate['role'],
                'number' => $dateForUpdate['number'],
                'email' => $dateForUpdate['email'],
            ]);
        } catch (\Exception $e) {
            return back()->with('faield' , $e->getMessage());
        }

        return back()->with('success' , 'کاربر بروزرسانی شد');
    }

    public function delete(int $user_id)
    {
        User::findOrFail($user_id)->delete();

        return back()->with('success' , 'کاربر حذف شد');
    }
}
