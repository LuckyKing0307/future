<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function withdrawal(){

    }
    public function invite(){

    }
    public function team(){

    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
