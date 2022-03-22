<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\BlockUser;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;

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
        $user = User::where('email', $request->email)->with('lot.block')->first();

        if ( $user &&  Hash::check($request->password, $user->password)) {
            Auth::login($user,$request['remember']);
            $request->session()->regenerate();  
 
            return response()->json($user);
        }
        return response()->json(["error"=>"Invalid Credentials, please try again"],401);
               
    }
    
    public function store(RegisterRequest $request) : JsonResponse
    {
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
            User::with(['lot.block'])->get()
        );
    }

     public function notBlockedUsers(Request $request) : JsonResponse
    {   
        
        $block_user_ids=DB::table('block_users')->where('user_id',$request->route('user'))->pluck('block_user_id')->toArray();
        $block_users =User::whereNotIn('id',$block_user_ids)->get();

        return response()->json(
            $block_users
        );
    }


    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user) : JsonResponse
    {
        //  $block_user_ids=DB::table('block_users')->where('user_id',$request->route('user'))->pluck('block_user_id')->toArray();
        //  $user =User::whereNotIn('id',$block_user_ids)->get();
        return response()->json( $user);
    }
   
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
  
        User::query()->where('id',$request->route('user'))->update($request->validate([
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
        return response()->json(User::where('id',$request->route('user'))->with(['lot.block'])->get());
  
    }
  
    public function changePassword(Request $request) : JsonResponse{
        $request->validate([
            'old_password' => ['required','password'],
            'new_password' => ['required','min:8' ],
            'confirm_password' => ['required','same:new_password' ],
            
        ]);
        if (Hash::check($request['old_password'],Auth::user()->password)){
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request['new_password']);
            if($user->save()){
               return response()->json($user);
            }
        }else{
            $response = [
                'old_password' => 'Current Password is incorrect',
            ];
            return response()->json($response,404);
        }
        
    }
    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
         ]);
        $status = Password::reset(
            $request->only( 'password' ,'email', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                event(new PasswordReset($user));
            }

        );
        if($status == Password::PASSWORD_RESET){
            return response([
                'message' => 'Password reset successfully'
            ]);
        }else{
             return response([
                'email' => 'Invalid Email'
            ]);
        }
    }
    public function forgotPassword(Request $request) 
    {
        $request->validate([
            'email' => ['required','email'],
        ]);

        $status = Password::sendResetLink(
                $request->only('email')
        );
        if($status == Password::RESET_LINK_SENT){
            return response([
                'status' => __($status) . "    note: check your email in spam folder",
            ]);
        }
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);

    }
    public function userLogged(): JsonResponse{
        if($id= Auth::user()->id)
             return response()->json( User::where('id',$id)->with('lot.block')->get());
        
        else
            return null;
    }

    public function destroy(User $user) : JsonResponse
    {
        $user->delete();

        return response()->json(['ok']);
    }
  
}
