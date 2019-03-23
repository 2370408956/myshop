<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edituser()
    {
        $userinfo=User::where('u_id',session('u_id'))->first();
        return view('edituser',['userinfo'=>$userinfo]);
    }

    public function quit()
    {
        session(['u_id'=>null]);
        session(['u_name'=>null]);
        return redirect('/');
    }
}
