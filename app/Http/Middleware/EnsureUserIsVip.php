<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsVip
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in, has a vipStatus relation, and if the status is true
        if (!$request->user() || !$request->user()->vipStatus || !$request->user()->vipStatus->status) {
            return redirect('home')->with('error', 'This area is only for VIP members.');
        }

        return $next($request);
    }
}

