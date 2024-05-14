<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Crypt;

class ssoController extends Controller
{


    public function index($id, $user, $course)
    {
        $idcard = Crypt::decrypt($id);
            dd($idcard,$user,$course);
    }

    public function ssoLogin($user)
    {
        return view('login_sso', ['user' => $user]);
    }
}
