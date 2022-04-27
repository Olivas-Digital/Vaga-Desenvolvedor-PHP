<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Email or password invalid.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Register a new user and get a JWT.
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
        ]);

        User::create($validated);

        return response()->json([
            'message' => 'Created successfully',
        ], Response::HTTP_CREATED);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
