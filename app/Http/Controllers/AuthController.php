<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Users
 */
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
     * Login
     *
     * Get a JWT via given credentials.
     *
     * @unauthenticated
     *
     * @response {"access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwib"}
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

        Log::info('User logs in.', [
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'userAgent' => $request->userAgent(),
        ]);

        return $this->respondWithToken($token);
    }

    /**
     * Logout
     *
     * Log the user out (Invalidate the token).
     *
     * @response {"message": "Successfully logged out"}
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        Log::info('User logs out.', [
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'userAgent' => $request->userAgent(),
        ]);

        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Register
     *
     * Register a new user and get a JWT.
     *
     * @unauthenticated
     *
     * @response 201 {"message": "Created successfully"}
     *
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

        $user = User::create($validated);

        Log::info('User registered.', [
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'userAgent' => $request->userAgent(),
        ]);

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
