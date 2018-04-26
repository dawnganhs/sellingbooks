<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIBaseController as APIBaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends APIBaseController
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // public function getUserInfo(Request $request)
    // {
    //     $user = User::where('api_token', $request->api_token)->get();
    //     return response()->json(['data' => $user]);
    // }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return response()->json(['api_token' => Auth::user()->api_token]);
        } else {
            return $this->sendError('Email or password is not correct !');
        }
    }

    public function create(Request $request)
    {
        if(User::where('email', $request->email)->first()){
            return $this->sendError('Email already exits, please enter another email !');
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'age' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ], [
            'name.required' => 'Please enter name',
            'email.required' => 'Please enter email',
            'password.required' => 'Please enter password',
            'age.required' => 'Please enter age',
            'address.required' => 'Please enter address',
            'phone.required' => 'Please enter phone',
            'role.required' => 'Please enter role',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = new User;
        $user->name = $request->name;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $file->move('./images', $file->getClientOriginalName('avatar'));
            $avatar = $file->getClientOriginalName('avatar');
            $user->avatar = $avatar;
        }
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->age = $request->age;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->api_token = str_random(60);
        $user->save();
        return $this->sendResponse($user, 'Created new user successfully !');
    }

    public function update(Request $request)
    {
        $user = User::where('id', Auth::guard('api')->id())->first();
        $db_user = User::get();
        if ($user->email !== $request->email) {
            foreach ($db_user as $results) {
                if ($request->email == $results->email) {
                    return $this->sendError('Email already exits, please enter another email !');
                }
            }
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'age' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ], [
            'name.required' => 'Please enter name',
            'email.required' => 'Please enter email',
            'password.required' => 'Please enter password',
            'age.required' => 'Please enter age',
            'address.required' => 'Please enter address',
            'phone.required' => 'Please enter phone',
            'role.required' => 'Please enter role',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $file->move('./images', $file->getClientOriginalName('avatar'));
            $avatar = $file->getClientOriginalName('avatar');
            $user->avatar = $avatar;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->age = $request->age;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->save();
        return $this->sendResponse($user, 'Updated successfully !');
    }
    public function logout()
    {
        Auth::logout();
        return $this->sendMessage('You are just logout !');
    }

    public function show()
    {
        $user = User::where('id', Auth::guard('api')->id())->first();
        if (is_null($user)) {
            return $this->sendError('User not found !');
        } else {
            return $this->sendData($user);
        }
    }
}
