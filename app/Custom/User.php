<?php


namespace App\Custom;

use App\Models\UserSetting;
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

    /**
     * Function for updating the user setting in the users_settings table
     */
    public static function addSetting($key, $value, int $user_id = null){
        if(!$user_id){
            // get the user id from auth

        }
        // create the array for storage
        $data = [
            'key' => $key,
            'value' => $value,
            'user_id' => $user_id
        ];
        $check = [
            'key' => $key,
            'user_id' => $user_id
        ];
        return UserSetting::updateOrCreate($check, $data);
    }

    public static function getSettings($user_id, array $keys = []){
        if ($keys == []){
            // get all the settings
            return UserSetting::where('user_id', $user_id)->pluck('value', 'key');
        }
        return UserSetting::where('user_id', $user_id)->whereIn('key', $keys)->pluck('value', 'key');
    }
}
