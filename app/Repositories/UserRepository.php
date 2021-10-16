<?php


namespace App\Repositories;


use App\Models\Candidate;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserRepository
{
    public static function updateUserRole($user_id, $role){
        $user = User::find($user_id);
        switch ($role){
            case 'employer':
                // create an employer profile
                $data = ['original_user' => $user_id];
                $created = Company::updateOrCreate($data, $data);

                // assign a rol
                $updated = User::where('id', $user_id)->update(['role' => $role]);
                $user->assignRole($role);
                return route('my-company.edit');
                break;
            case 'candidate':
                // create candidate
                $data = ['user_id' => $user_id];
                $created = Candidate::updateOrCreate($data, $data);
                // update the user role column
                $updated = User::where('id', $user_id)->update(['role' => $role]);
                $user->assignRole($role);
                // Redirect user to create a profile
                return route('my-resume.edit');
                break;
        }
    }
}
