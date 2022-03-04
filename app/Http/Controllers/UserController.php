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
    public function create(Request $request){
      $user = new User;
      $user->apellido_paterno = request('apellido_paterno');
      $user->apellido_materno = request('apellido_materno');
      $user->nombres = request('nombres');
      if(strlen(request('email'))>0)
        $user->email = request('email');
      if(request('password') == request('password_confirmation') && strlen(request('password')) > 0)
        $user->password = bcrypt(request('password'));
      else
        return redirect()->back()->with('danger', 'Las contraseñas no coinciden o son nulas');
      if( strlen(request('usuario')) === 0)
        return view('auth.register')->with('danger', 'El nombre de usuario no puede ser nulo');
      try{
        $user->usuario = request('usuario');
        $user->save();
      } catch(\Illuminate\Database\QueryException $e){
        return redirect()->back()->with('danger', 'El nombre de usuario ya está ocupado');
      }
      return redirect('/admin')->with('success', 'El usuario ha sido registrado');
    }
}
