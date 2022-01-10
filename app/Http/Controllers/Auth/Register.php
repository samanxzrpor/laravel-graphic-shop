<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Register
{


    public static function storeUser(Request $request)
    {
        $dataForStore = $request->validate([
            'name' => 'required|min:4|max:256',
            'email' => 'required|email|min:7|max:256',
            'mobile' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        
        try {
            $storedUser = User::create([
                'name' => $dataForStore['name'],
                'email' => $dataForStore['email'],
                'role' => $dataForStore['role'] ? strval($dataForStore['role']) : 'user',
                'number' => $dataForStore['number'],
                'password' => Hash::make($dataForStore['password'])
            ]);

        } catch (\Exception $e) {

            return back()->with('failed' , $e->getMessage());
        }

        return $storedUser;
    }

}