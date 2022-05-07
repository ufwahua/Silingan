<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Candidate;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function login(Request $request): JsonResponse
    {
       $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password) && $user->verified ) {
            Auth::login($user, $request['remember']);
            $request->session()->regenerate();
            return response()->json($user);
        } else if ($user && Hash::check($request->password, $user->password) && !$user->verified) {
            return response()->json(["errors" => "Not verified, please contact admin or the officers"], 401);
        } else {
            return response()->json(["errors" => "Invalid Credentials, please try again"], 412);
        }
    }

    public function store(Request $request): JsonResponse
    {
       $request = request();
        if ($request['role'] == 'security officer' || $request['role'] == 'admin') {
            if($request['role'] == 'security officer'){
                 $request->validate([
                    'email'                 => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->route('user'))],
                    'password'              => ['required', 'min:8'],
                    'confirm_password'     => ['required', 'same:password', 'min:8'],
                    'first_name'            => ['required', 'string', 'max:255'],
                    'last_name'             => ['required', 'string', 'max:255'],
                    'gender'                => ['required'],
                    'age'                   => ['required', 'integer', 'numeric', 'gt:0', 'max:130'],
                    'contact_num'           => ['required','string','min:10'],
                    'profile_pic'           => ['sometimes'],
                    'has_voted'             => ['required'],
                    'verified'              => ['required'],
                    'status'                => ['required'],
                    'role'                  => ['required'],
                    'position_id'           => ['sometimes'],
                    'tag_as'                => ['sometimes'],
                    'security_shift'        => ['required'],
                ]);
                 $user = User::query()->create([
                    'email'                 => $request['email'],
                    'password'              => Hash::make($request['password']),
                    'first_name'            => $request['first_name'],
                    'last_name'             => $request['last_name'],
                    'gender'                => $request['gender'],
                    'age'                   => $request['age'],
                    'contact_num'           => $request['contact_num'],
                    'has_voted'             => $request['has_voted'],
                    'verified'              => $request['verified'],
                    'status'                => $request['status'],
                    'role'                  => $request['role'],        
                    'security_shift'        => $request['security_shift'],        
                ]);   
            }else{
                 $request->validate([
                    'email'                 => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->route('user'))],
                    'password'              => ['required', 'min:8'],
                    'confirm_password'     => ['required', 'same:password', 'min:8'],
                    'first_name'            => ['required', 'string', 'max:255'],
                    'last_name'             => ['required', 'string', 'max:255'],
                    'gender'                => ['required'],
                    'age'                   => ['required', 'integer', 'numeric', 'gt:0', 'max:130'],
                    'contact_num'           => ['required','string','min:10'],
                    'profile_pic'           => ['sometimes'],
                    'has_voted'             => ['required'],
                    'verified'              => ['required'],
                    'status'                => ['required'],
                    'role'                  => ['required'],
                    'position_id'           => ['sometimes'],
                    'tag_as'                => ['sometimes'],
                ]);
                $user = User::query()->create([
                    'email'                 => $request['email'],
                    'password'              => Hash::make($request['password']),
                    'first_name'            => $request['first_name'],
                    'last_name'             => $request['last_name'],
                    'gender'                => $request['gender'],
                    'age'                   => $request['age'],
                    'contact_num'           => $request['contact_num'],
                    'has_voted'             => $request['has_voted'],
                    'verified'              => $request['verified'],
                    'status'                => $request['status'],
                    'role'                  => $request['role'],        
                ]); 
            }
            
        } else {
             $request->validate([
                'block_lot_id'          => ['required',Rule::exists('lots', 'id')],
                'email'                 => ['required','string' ,'email', 'max:255',Rule::unique('users')->ignore($request->route('user'))],
                'password'              => ['required' , 'min:8'],
                'confirm_password'     => ['required','same:password' , 'min:8'],
                'first_name'            => ['required','string' , 'max:255'],
                'last_name'             => ['required','string' , 'max:255'],
                'gender'                => ['required'],
                'age'                   => ['required','integer','numeric','gt:0', 'max:130'],
                'contact_num'           => ['required','string','min:10'],
                'profile_pic'           => ['sometimes'],
                'has_voted'             => ['required'],
                'verified'              => ['required'],
                'status'                => ['required'],
                'role'                  => ['required'],
                'position_id'           => ['sometimes'],
                'tag_as'                => ['required'],
            ]);
            $user = User::query()->create([
                'block_lot_id'          => $request['block_lot_id'],
                'email'                 => $request['email'],
                'password'              => Hash::make($request['password']),
                'first_name'            => $request['first_name'],
                'last_name'             => $request['last_name'],
                'gender'                => $request['gender'],
                'age'                   => $request['age'],
                'contact_num'           => $request['contact_num'],
                'has_voted'             => $request['has_voted'],
                'verified'              => $request['verified'],
                'status'                => $request['status'],
                'role'                  => $request['role'],
                'tag_as'                => $request['tag_as'],
            ]);        
        }

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
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            User::with(['lot.block','position','emergency_contact'])->latest()->get()
        );
    }

    public function notBlockedUsers(Request $request): JsonResponse
    {

        $block_user_ids = DB::table('block_users')->where('user_id', $request->route('user'))->pluck('block_user_id')->toArray();
        $block_users = User::whereNotIn('id', $block_user_ids)->latest()->get();

        return response()->json(
            $block_users
        );
    }


    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        //  $block_user_ids=DB::table('block_users')->where('user_id',$request->route('user'))->pluck('block_user_id')->toArray();
        //  $user =User::whereNotIn('id',$block_user_ids)->get();
        return response()->json($user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        if ($request['role'] == 'security officer' || $request['role'] == 'admin' ) {
            if($request['role'] == 'security officer'){
                User::query()->where('id', $request->route('user'))->update($request->validate([
                    'block_lot_id' => ['sometimes'],
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'gender' => ['required'],

                    'age' => ['required', 'integer', 'numeric', 'gt:0', 'max:130'],
                    'contact_num' => ['required','string','min:10'],
                    'role' => ['required'],
                    'status' => ['required'],
                    'verified' => ['required'],
                    'has_voted' => ['required'],
                    'tag_as' => ['sometimes'],
                    'profile_pic'=> ['sometimes'],
                    'security_shift'=> ['required'],
                    'flagged'=> ['sometimes'],
                ]));
            }else{
                 User::query()->where('id', $request->route('user'))->update($request->validate([
                    'block_lot_id' => ['sometimes'],
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'gender' => ['required'],
                    'age' => ['required', 'integer', 'numeric', 'gt:0', 'max:130'],
                    'contact_num' => ['required','string','min:10'],
                    'role' => ['required'],
                    'status' => ['required'],
                    'verified' => ['required'],
                    'has_voted' => ['required'],
                    'tag_as' => ['sometimes'],
                    'profile_pic'=> ['sometimes'],
                    'security_shift'=> ['sometimes'],
                    'flagged'=> ['sometimes'],
                ]));
            }
         
        } else {
            User::query()->where('id', $request->route('user'))->update($request->validate([
                'block_lot_id' => ['required', Rule::exists('lots', 'id')],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'gender' => ['required'],
                'age' => ['required', 'integer', 'numeric', 'gt:0', 'max:130'],
                'contact_num' => ['required','string','min:10'],
                'role' => ['required'],
                'status' => ['required'],
                'verified' => ['required'],
                'has_voted' => ['required'],
                'profile_pic'=> ['sometimes'],
                'tag_as' => ['required'],
                'position_id' => ['sometimes'],
                'flagged'=> ['sometimes'],
            ]));
        }

        return response()->json(User::where('id', $request->route('user'))->with(['lot.block'])->get());
    }

    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'old_password' => ['required', 'password'],
            'new_password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],

        ]);
        if (Hash::check($request['old_password'], Auth::user()->password)) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request['new_password']);
            if ($user->save()) {
                return response()->json($user);
            }
        } else {
            $response = [
                'old_password' => 'Current Password is incorrect',
            ];
            return response()->json($response, 404);
        }
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $status = Password::reset(
            $request->only('password', 'email', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                event(new PasswordReset($user));
            }

        );
        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message' => 'Password reset successfully'
            ]);
        } else {
            return response([
                'email' => 'Invalid Email'
            ]);
        }
    }
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status == Password::RESET_LINK_SENT) {
            return response([
                'status' => __($status) . "    note: check your email in spam folder",
            ]);
        }
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
    public function userLogged(): JsonResponse
    {
        if ($id = Auth::user()->id)
            return response()->json(User::where('id', $id)->with('lot.block')->get());

        else
            return null;
    }
    public function getSearchUser(Request $request): JsonResponse
    {
       
        $users = User::orWhere(DB::raw("LOWER(concat(first_name, ' ', last_name))"), 'LIKE', "%".strtolower($request->input('query'))."%")
                       ->where('verified',1)
                       ->with(['lot.block','position','emergency_contact'])
                       ->latest()
                       ->get();  
        return response()->json($users);
        
    }
    public function getUsersVerified(Request $request): JsonResponse
    {
       
        $users =  User::where('verified',1)
        ->with(['lot.block','position'])->get();

        return response()->json($users);
        
    }
    public function filterResident(Request $request): JsonResponse
    {
        $candidates_user_id = DB::table('candidates')->where('election_id', $request->route('user'))->pluck('user_id')->toArray();
        $users = User::whereNotIn('id', $candidates_user_id)
        ->where('verified',1)
        ->whereNested(function($query)  {
        $query
            ->where('role', 'resident')
            ->orWhere('role', 'officer');
            
        })
        ->with(['lot.block','position'])->get();
       

        return response()->json($users);
        
    }
     public function getOfficers(Request $request): JsonResponse
    {
        $users =  User::where('role','officer')->with(['lot.block','position'])->get();
        $req = [];
        foreach ($users as $user){
            if(strtoupper($user->position['name']) === "PRESIDENT"){
                array_push($req,$user);
                break;
            }
        };
        foreach ($users as $user){
            if(strtoupper($user->position['name']) === "VICE-PRESIDENT"){
                array_push($req,$user);
                break;
            }
        };
        foreach ($users as $user){
            if(strtoupper($user->position['name']) === "SECRETARY"){
                array_push($req,$user);
                break;
            }
        };
        foreach ($users as $user){
            if(strtoupper($user->position['name']) === "TREASURER"){
                array_push($req,$user);
                break;
            }
        };
        foreach ($users as $user){
            if(strtoupper($user->position['name']) === "AUDITOR"){
                array_push($req,$user);
                break;
            }
        };
        foreach ($users as $user){
            if(strtoupper($user->position['name']) === "AUDITOR" || strtoupper($user->position['name']) === "TREASURER" ||strtoupper($user->position['name']) === "SECRETARY" ||strtoupper($user->position['name']) === "VICE-PRESIDENT" ||strtoupper($user->position['name']) === "PRESIDENT"){
                
            }
            else{
                array_push($req,$user);
            }
        };
       
        return response()->json(
           $req
        );
        
       
    }
     public function getResidents(Request $request): JsonResponse
    {
        $users =  User::where('role','resident')->with(['lot.block','position','emergency_contact'])->get();
       
        
        return response()->json(
           $users
        );
        
       
    }

   
    public function updateHasVoted(Request $request): JsonResponse
    {
      
        User::query()->where('id', $request->route('user'))->update([
            'has_voted' => $request['has_voted'],
        ]);

        return response()->json(['ok']);
    }
     public function getResidentInBlockLot(Request $request): JsonResponse
    {
      
        $user = User::where('block_lot_id',$request->route('user'))->get();
        
        return response()->json($user);
    }
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['ok']);
    }
}
