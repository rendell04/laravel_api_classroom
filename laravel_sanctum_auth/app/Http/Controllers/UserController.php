<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator;

use Auth;

class UserController extends Controller
{

    public function test(Request $request){

        return $request->email;
    }
    //the login script, with token
    public function index(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // // compare if request and the user pass are the same
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => 'These credentials do not match our records.'
                ]);
            }
            
            else{

                //set user as logged in
                Auth::login($user);
                // $token='';
                //create token
                $token = $user->createToken('my-app-token')->plainTextToken;
                $response = [
                    'user' => $user,
                    'token' => $token
                ];

                return $response;
            }
    }


    //create a user 
     public function create(Request $request){
        $user = new User;

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->password = Hash::make('default');
        $user->save();
        
        return response($request, 201);
    }


    //show all users
    public function users(){
        // return User::all()->paginate(5);
        return DB::table('users')->paginate(5);
    }

    //show specific users
    public function user($id){
        $user= User::findOrFail($id);
        return $user;
    }


     //update user data
    public function update(Request $request){

        $user= User::where('id', $request->id)->first();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($user->save()) {
            return $user;
        }
    }

    public function destroy($id){
        // Get article
        $user = User::findOrFail($id);
        $deleted_user = $user;

        if ($user->delete()) {
            return $deleted_user;
        }
        return null;
    }

    
    //delte the token, user log out.
    public function logout($id){
        $user= User::findOrFail($id);
        $user->tokens()->where('tokenable_id', $id)->delete();

        //set user as log out in
        // Auth::logout($user);
        return $user;
    }


    public function admin(){
        //  return view('welcome')->withMessage('Admin');
        return "ADMIN NI";
    }
    
}
