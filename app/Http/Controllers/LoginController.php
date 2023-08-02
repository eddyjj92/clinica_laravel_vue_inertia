<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return Auth::user() ? redirect()->intended('dashboard'): Inertia::render('Login', ['denied' => $request->input('denied') ? : false ]);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'usuario' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors(['validacion' => 'Ha ocurrido un error '.$validator->errors()]);
        }
        if(Auth::attempt(['email' => $request['usuario'], 'password' => $request['password']])){
            return redirect()->intended('dashboard');
        }else{
            return back()->withErrors(['validacion' => 'Credenciales Incorrectas']);
        }

    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
