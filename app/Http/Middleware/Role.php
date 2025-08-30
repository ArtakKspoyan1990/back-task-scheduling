<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{

    /**
     * @param Request $request
     * @param Closure $next
     * @param mixed ...$roles
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('api')->user();
        if (!in_array($user->role, ['manager', 'customer']) ||  $user->is_available == 0) { return response()->json(['message'=>'Forbidden'], 403); }
        return $next($request);
    }
}
