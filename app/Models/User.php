<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function Products()
    {
        return $this->hasMany(Product::class);
    }

    public static function getUsersRoles()
    {
        $enomTypes = [];

        $dataFromDatabase = DB::select(DB::raw('SHOW COLUMNS FROM users WHERE FIELD = "role"'))[0]->Type;

        preg_match('/enum\((.*)\)$/' ,$dataFromDatabase , $matches);

        $enoms = explode(',' , $matches[1]);

        foreach ($enoms as $value) {

            $enomTypes[] = trim($value , "'");
        }

        return $enomTypes;
    }
}
