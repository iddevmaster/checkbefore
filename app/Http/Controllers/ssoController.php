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
        $course_name = Crypt::decrypt($course);
        $userRows = DB::table('users')
            ->where('email', '=', $idcard)
            ->get();

        if ($course_name  == 'car') {
            $course_id = 'QNFS80B5SA';
        } elseif ($course_name == 'motobike') {
            $course_id = 'LH8YEZGBTK';
        } elseif ($course_name == 'trailer') {
            $course_id = '1DEQEYL3OW';
        }

        if (count($userRows) == 0) {
            $user_id = Str::upper(Str::random(15));
            User::create([
                'user_id' => $user_id,
                'name' => $user,
                'email' => $idcard,
                'password' => Hash::make($id),
                'role' => 'user',
                'user_dep' => $course_id
            ]);

            DB::table('user_details')->insert([
                'user_id' => $user_id,
                'fullname' => $user,
                'user_logo' => '0',
                'user_status' => '1',
                'user_dep' => $course_id,
                'created_at' => Carbon::now()
            ]);
        } elseif (count($userRows) >= 1) {
            return view('login_sso', ['user' => $idcard]);
        }

        return view('login_sso', ['user' => $idcard]);
    }

    public function ssoLogin($user)
    {
        return view('login_sso', ['user' => $user]);
    }
}
