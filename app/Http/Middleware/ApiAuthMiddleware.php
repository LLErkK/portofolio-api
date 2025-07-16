<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'errors' => [
                    'message' => ['Unauthorized: No token provided.']
                ]
            ], 401);
        }

        $user = User::where('token', $token)->first();

        if (!$user) {
            return response()->json([
                'errors' => [
                    'message' => ['Unauthorized: Invalid token.']
                ]
            ], 401);
        }

        // Login ke Auth system (opsional, untuk Auth::user())
        Auth::login($user);

        // Set user untuk $request->user()
        $request->setUserResolver(function () use ($user) {
            \Log::info('User from middleware', ['id' => $user->id]);

            return $user;
        });

        return $next($request);
    }
}
