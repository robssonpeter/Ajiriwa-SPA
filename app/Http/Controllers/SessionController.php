<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function createSession(){
        $name = request()->name;
        $value = request()->value;

        session()->put($name, $value);
        return true;
    }
}
