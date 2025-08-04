<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $dayOfWeek = Carbon::now()->dayOfWeekIso;
        if (in_array($dayOfWeek, [6, 7])) {
            return redirect('/home');
        }

        if ($code = $request->query('ref')) {
            if ($referrer = User::find($code)) {
                session(['is_referal' => $referrer->id]);
            }
        }

        return $next($request);
    }
}
