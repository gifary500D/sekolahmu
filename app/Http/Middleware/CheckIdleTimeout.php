<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIdleTimeout
{
    /**
     * Handle an incoming request.
     * BRL-13: 120 minutes idle timeout.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $lastActivity = session('last_activity');
            $timeout = 120 * 60; // 120 minutes in seconds

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->withErrors([
                    'login' => 'Sesi Anda telah berakhir karena tidak aktif selama 120 menit. Silakan masuk kembali.',
                ]);
            }

            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
