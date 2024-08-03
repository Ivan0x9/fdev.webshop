<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company' => ['nullable', 'string', 'max:255'],
            'tax_number' => ['nullable', 'numeric'],
        ]);

        if($validation->fails()) {
            return $this->sendError("Validation error!", $validation->errors(), 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company' => $request->filled('company') ? $request->get('company') : null,
            'tax_number' => $request->filled('tax_number') ? $request->get('tax_number') : null,
        ]);

        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();

        $success = [
            'token' => $user->createToken(env('APP_NAME'))->plainTextToken,
            'name' => $user->name,
        ];

        event(new Registered($user));

        Auth::login($user);

        return $this->sendResponse($success, "User registered. Logged in.");
    }

    /**
     * Handle an incoming login request.
     *
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @var $user App\Models\User
     * 
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            /**
             * @var $user App\Models\User
            */
            $user = Auth::guard('sanctum')->user();

            $success = [
                'token' => $user->createToken(env('APP_NAME'))->plainTextToken,
                'name' => $user->name,
            ];

            return $this->sendResponse($success, 'User logged in successfully.');
        } 
        else{ 
            return $this->sendError('User not authorised.', ['error' => 'Unauthorised access'], 401);
        } 

    }

    /**
     * Handle log out user.
     */
    public function logout(): JsonResponse
    {
        /**
         * @var $user App\Models\User
        */
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('User not authenticated', ['error'=>'Unauthenticated'], 403);
        }
 
        try {
            $user->tokens()->delete();
        } catch (\Exception $e) {
            return $this->sendError('Unable to revoke tokens', [$e], 403);
        }
 
        return $this->sendResponse($user, 'User logged out successfully.');
    }
}
