<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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
    
    public function store(RegisterRequest $request) : JsonResponse
    {
        // $user = User::query()->create($request->validate([
        //     'block_lot_id' => ['required',Rule::exists('lots', 'id')],
             
        //     'first_name' => ['required','string' , 'max:255'],
        //     'last_name' => ['required','string' , 'max:255'],
        //     'gender' => ['required'],
        //     'block_lot_id' => ['sometimes'],
        //     'age' => ['required','integer','numeric','gt:0', 'max:130'],
        //     'contact_num' => ['required','string','min:11'],
        //     'role' => ['required'],
        //     'verified' => ['required'],
        //     'has_voted' => ['required'],

        //    'email' => ['required','string' ,'email', 'max:255',Rule::unique('users')->ignore($this->route('user'))],
        //     'password' => ['required' , 'min:8'],
        //     'confirm_password' => ['required','same:password' , 'min:8'],
        //     'profile_pic'=> ['sometimes'],
        // ]));
        $user = User::query()->create($request->validated());

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
            User::with('blockLot.block')->get()
        );
    }
    

    // public function index2(Request $request) : JsonResponse
    // {
    //     $users = User::select("*", DB::raw("CONCAT(users.first_name,' ',users.last_name) as full_name"))
    //     ->get();

    //     foreach ($users as $user)
    //     $full_name = $user->first_name. " " .$user->last_name;
    //     return response()->json($full_name)
            
    //     ;
    // }

    public function index2(User $user) : JsonResponse
    {   
         $users =User::all();
         $req= [];
         foreach($users as $user){
             $request = [
                 'user'=> $user,
                 'full_name' => $user->first_name ." ". $user->last_name,
             ];
             array_push($req,$request);
         }
            return response()->json(
            $req
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
    public function update(Request $request): JsonResponse
    {
  
    $user = User::query()->where('id',$request->route('user'))->update($request->validate([
        'block_lot_id' => ['required',Rule::exists('lots', 'id')],
        'first_name' => ['required','string' , 'max:255'],
        'last_name' => ['required','string' , 'max:255'],
        'gender' => ['required'],
        'block_lot_id' => ['sometimes'],
        'age' => ['required','integer','numeric','gt:0', 'max:130'],
        'contact_num' => ['required','string','min:11'],
        'role' => ['required'],
        'verified' => ['required'],
        'has_voted' => ['required'],
        'email' => ['required','string' ,'email', 'max:255',Rule::unique('users')->ignore($request->route('user'))],
        'profile_pic'=> ['sometimes'],
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
