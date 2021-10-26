<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $messages = [
            'email.required' => 'O E-mail é obrigatório',
            'password.required' => 'A senha é obrigatoria',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], $messages);

        if ($validator->fails()) {
            // return response()->json($validator->errors(), 422);
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Erros de validação',
                'errors'      => $validator->errors(),
            ], 422));
        }

        if (!$token = auth()->attempt($validator->validated())) {
            // return response()->json(['error' => 'Unauthorized'], 401);
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Erros de validação',
                'errors'      => $validator->errors(),
            ], 401));
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'Nome é obrigatório',
            'name.between' => 'Nome precisa ter entre 2 a 100 caracteres',
            'email.required' => 'O E-mail é obrigatório',
            'email.email' => 'E-mail não é válido',
            'email.unique' => 'E-mail já cadastrado',
            'password.required' => 'A senha é obrigatoria',
            'password.confirm' => 'As senhas não conferem',
            'password.min' => 'A senha precisa ter 6 ou mais caracteres',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ], $messages);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Erros de validação',
                'errors'      => $validator->errors(),
            ], 400));
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'Usuário registrado!',
            'data' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Usuário saiu!']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
