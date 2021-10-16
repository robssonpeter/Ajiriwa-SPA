<?php


namespace App\Custom;


use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class User
{
    const ROLES = [

    ];

    public static function createAdmin(){
        $data = [
            'name' => 'admin',
            'email' => 'peterrobsson1994@gmail.com',
            'password' => Hash::make('12345678')
        ];

        // Check if admin user exists
        $check = \App\Models\User::where('name', 'admin')->first();

        $user = null;
        if(!$check){
            // create a new entry
            $user = \App\Models\User::create($data);

            if($user){
                // give user admin role
                $user->assignRole('admin');
                event(new Registered($user));
            }
        }

        return $user;
    }
}
