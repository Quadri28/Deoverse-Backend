<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('', 'Credentials do not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        return $this->success([
            'user'=> $user,
            'token'=> $user->createToken('Api Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function signup(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of' . $user->name)->plainTextToken
        ]);
    }
   
    public function user(){
        $user = User::where('role', 'user')->get();
        return $this->success([
            'data' => $user
        ]);
    }

    public function update(Request $request, $id){
        $user = User::where($id)->first(); 
        $user->is_confirmed = $request->is_confirmed;
        $id->update($user);
        return $this->success([
            'data' => $user
        ]);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }
}
