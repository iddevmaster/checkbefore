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
    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    public function index($id,$user,$course)
    {
        $userRows = DB::table('users')
        ->where('email','=', $id)
        ->get();

        if($course == 'car')
        {
            $course_id = '2JD9LFPDNO';
        }

        if(count($userRows) == 0) {
            $user_id = Str::upper(Str::random(15));
            return User::create([
                'user_id'=> $user_id,
                'name' => $user,
                'email' => $id,
                'password' => Hash::make($id),
                'role' => 'user',
                'user_dep' => $course_id
            ]);
        }
        
        return redirect()->route('ssoLogin');
    }

  

}
