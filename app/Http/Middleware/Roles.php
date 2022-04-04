<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        if (!Auth::check()) 
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => 'unautorized'
            ]);

        $user = User::find(Auth::id());

        foreach($roles as $role) {
            if($user->hasRole($role))
                return $next($request);
        }

        return response()->json([
                'success' => false,
                'code' => 403,
                'message' => 'unautorized'
            ]);
    }
}
