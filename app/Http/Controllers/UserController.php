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
    
    public function verUsuarios() {
      if(Auth::user()->es_admin)
        return view('pages.ver-usuarios')->with('users', User::all());
      return redirect('/admin');
    }

    public function crear() {
      if(!Auth::user()->es_admin)
        return redirect('/admin');
      return view('auth.register');
    }

    public function edit($id)
    {
      if(Auth::user()->es_admin){
        $user = User::findOrFail($id);
        return view("pages.update-usuario")
            ->with("user",$user);
      }
      return redirect('/admin');
    }


    
    public function update($id, Request $request)
    {
      if(!Auth::user()->es_admin)
        return redirect('/admin');
      $user = User::findOrFail($id);
        if (Hash::check($request->current_password, $user->password)) {
            $user->nombre = request('nombre');
            $user->email = request('email');
            if(strlen(request('password')) > 0)
              if(request('password') == request('password_confirmation'))
                $user->password = bcrypt(request('password'));
              else
                return redirect()
                  ->back()
                  ->with('danger', 'La contraseña nueva no coincide con su confirmación');
            if( strlen(request('usuario')) === 0)
              return redirect()
                ->back()
                ->with('danger', 'El nombre de usuario no puede ser nulo');
            if($request->es_admin)
              $user->es_admin = true;
            else
              $user->es_admin = false;
            try{
              if($user->usuario != request('usuario'))
                $user->usuario = request('usuario');
              $user->save();
              return redirect()->route('verUsuarios')->with('success','Cambios realizados correctamente');
            } catch(\Illuminate\Database\QueryException $e){
              return redirect()
                ->back()
                ->with('danger', 'El nombre de usuario ya está ocupado');
            }
        }
        return redirect()->back()->with('danger','La contraseña actual es incorrecta');
    }

    public function create(Request $request){
      if(!Auth::user()->es_admin)
        return redirect('/admin');

      $user = new User;
      $user->nombre = request('nombre');
      $user->email = request('email');
      if( strlen(request('usuario')) === 0)
        return redirect()->back()->with('danger', 'El nombre de usuario no puede ser nulo');
      $user->usuario = request('usuario');
      if(strlen(request('password')) == 0)
        return redirect()->back()->with('danger', 'No se ingresó una contraseña');
      if(!(request('password') === request('password_confirmation')))
        return redirect()->back()->with('danger', 'Las contraseñas no coinciden');
      $user->password = bcrypt(request('password'));
      if($request->es_admin)
        $user->es_admin = true;
      else
        $user->es_admin = false;
      try{
        $user->save();
      } catch(\Illuminate\Database\QueryException $e){
        return redirect()->back()->with('danger', 'El nombre de usuario ya está ocupado. Pruebe con otro.');
      }
      return redirect('/verUsuarios')->with('success', 'El usuario ha sido registrado');
    }

    public function delete($id){
      if(!Auth::user()->es_admin)
        return redirect('/admin');
      $user = User::findOrFail($id);
      $user->delete();
      return redirect()->back()->with('success','Cuenta de usuario eliminada correctamente');
    }
}
