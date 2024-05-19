<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnsureUserIsVip
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = Auth::id();
        Log::info('Checking VIP status for user: ' . $userId);

        $isVip = DB::table('vips')
                    ->where('user_id', $userId)
                    ->value('id');

        if ($isVip) {
            Log::info('User is VIP.');
            return $next($request);
        }

        Log::warning('User is not VIP.');
        return redirect('/')->withErrors('You do not have access to this section.');
    }

}
