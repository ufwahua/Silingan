<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
    public function login(LoginRequest $request) : JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if ( $user ||  Hash::check($request->password, $user->password)) {
            Auth::login($user,$request['remember']);
            $request->session()->regenerate();  
 
            return response()->json($user);
        }
        return response()->json(["error"=>"Invalid Credentials, please try again"],401);
        
        
        
  
                
    }
    public function store(User $user,RegisterRequest $request) : JsonResponse
    {

        $user = User::create([$request->validated()]);
        return response()->json($user);
        
        
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return $request;
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            User::all()
        );
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user) : JsonResponse
    {
        return response()->json($user);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(User $user, Request $request): JsonResponse
    {
       $user->update($request->validate([
           'first_name' => ['required','string' , 'max:255'],
            'last_name' => ['required','string' , 'max:255'],
            'gender' => ['required'],
            'block' => ['required'],
            'lot' => ['required'],
            'age' => ['required','integer','numeric','gt:0', 'max:150'],
            'contact_num' => ['required','string'],
            'email' => ['required','string' ,'email', 'unique:users,email,'.$request['id']],
            'role' => ['required','string'],
       ]));
        return response()->json($user);
  
    }
  
    public function getUserLogged(User $user) : JsonResponse
    {
        return response()->json(Auth::user());
    }

    public function forgotPassword(User $user) : JsonResponse
    {
        return response()->json(Auth::user());
    }

    public function destroy(User $user) : JsonResponse
    {
        $user->delete();

        return response()->json(['ok']);
    }
  
}
