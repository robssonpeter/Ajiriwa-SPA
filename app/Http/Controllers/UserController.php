<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userSelect(){
        return Inertia::render('Auth/UserSelect', [

        ]);
    }

    public function userAssignRole($role){
        $availableRoles = [
            'employer', 'candidate'
        ];
        if(in_array($role, $availableRoles)){
            $link = UserRepository::updateUserRole(Auth::user()->id, $role);
            if(filter_var($link, FILTER_VALIDATE_URL)){
                return Inertia::location($link);
            }
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
