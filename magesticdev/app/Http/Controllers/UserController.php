<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $data)
    {
        return Validator::make($data, [
            'nombres' => 'required|string|max:255',
            'usuario' => 'required|string|max:255|unique:users',
            'apellido_paterno' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'string|min:6|confirmed',
            'current_password' => 'password:api',
        ]);
    }
    
    public function edit(User $user)
    {
        $user = Auth::user();
        return view("pages.update-usuario")
            ->with("user",$user);
    }

    
    public function update(User $user, Request $request)
    {
        if (Hash::check($request->current_password, $request->user()->password)) {
            $user = Auth::user();
            $user->apellido_paterno = request('apellido_paterno');
            $user->apellido_materno = request('apellido_materno');
            $user->nombres = request('nombres');
            $user->email = request('email');
            $user->password = strlen(request('password')) > 0 ? bcrypt(request('password')) : $user->password;
            $user->save();
        }
        return view('welcome');
    }
}
