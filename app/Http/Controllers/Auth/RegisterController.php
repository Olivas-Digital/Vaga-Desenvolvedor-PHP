<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\WelcomeMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Notifications\WelcomeNotification;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],[
            'name.required' => 'Informe um nome válido!',
            'email.required' => 'Informe um e-mail válido!',
            'email.email' => 'Informe um e-mail válido!',
            'email.unique' => 'Este e-mail ja está cadastrado!',
            'password.required' => 'Informe um senha válida',
            'password.string' => 'Informe um senha válida',
            'password.min' => 'A senha deve ter no minimo 8 caracteres',
            'password.confirmed' => 'As senhas não coincidem',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        // Send welcome mail
        Mail::to($data['email'])->send(new WelcomeMail($data['name']));
        // Get and store JWT token
        $token = auth('api')->attempt(['email' => $data['email'], 'password' => $data['password']]);
        setcookie('token', $token, 0, '/');

        return $user;
    }
}
