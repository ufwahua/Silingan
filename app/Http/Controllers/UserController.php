<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();

        if ( $user ||  Hash::check($request->password, $user->password)) {
            Auth::login($user,$request['remember']);
             $request->session()->regenerate();  
        }
         else
            return response(["error"=>"Invalid Credentials, please try again"],401);

        return $user->createToken('lanex')->plainTextToken;
                
    }
    public function register(RegisterRequest $request)
    {

        if($user = User::create([
            'first_name'=> $request['first_name'],
            'last_name'=> $request['last_name'],
            'gender'=> $request['gender'],
            'block'=> $request->input("selected_block.block"),
            'lot'=> $request->input("selected_lot.lot"),
            'age'=> $request['age'] ,
            'contact_num'=> $request['contact_num'] ,
            'role'=> $request['role'] ,
            'email'=> $request['email'] ,
            'password'=> Hash::make($request['password']),
            'profile_pic'=> $request['profile_pic'],
            ])
        )
        return response($user,201);
  

    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request;
    }
    public function index(){
        return [
            'user' => Auth::user(),
            'id' => Auth::id()
        ];
    }
}
