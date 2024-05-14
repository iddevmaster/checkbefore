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

class ssoController extends Controller
{
   
    
    public function index($id,$user,$course)
    {
        $userRows = DB::table('users')
        ->where('email','=', $id)
        ->get();

        if($course == 'car')
        {
            $course_id = '2JD9LFPDNO';
        }elseif($course == 'motobike')
        {
            $course_id = 'G2EAFFZ55F';
        }elseif($course == 'trailer')
        {
            $course_id = 'Z0FQE1GKWN';
        }

        if(count($userRows) == 0) {
            $user_id = Str::upper(Str::random(15));
            User::create([
                'user_id'=> $user_id,
                'name' => $user,
                'email' => $id,
                'password' => Hash::make($id),
                'role' => 'user',
                'user_dep' => $course_id
            ]);

            DB::table('user_details')->insert([
                'user_id'=> $user_id,
                'fullname' => $user,
                'user_logo' => '0',
                'user_status' => '1',
                'user_dep' => $course_id,
                'created_at' => Carbon::now()
            ]);
            
        }elseif(count($userRows) >= 1)
        {
            return view('login_sso',['user'=>$id]);
        }
        
        return view('login_sso',['user'=>$id]);
    }

    public function ssoLogin($user)
    {
        return view('login_sso',['user'=>$user]);
    }
  

}
