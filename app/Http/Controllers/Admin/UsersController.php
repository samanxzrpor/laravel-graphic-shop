<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreUser;
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
}
