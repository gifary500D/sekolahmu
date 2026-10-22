<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    /**
     * Tangani request yang masuk.
     * Memaksa siswa yang belum mengubah kata sandi default (password_changed = false)
     * untuk memperbarui kata sandi terlebih dahulu sebelum mengakses fitur siswa.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isSiswa() && ! $user->password_changed) {
            $isPasswordRoute = $request->routeIs('siswa.password.form')
                || $request->routeIs('siswa.password.update')
                || $request->routeIs('api.password.update')
                || $request->is('api/ubah-password')
                || $request->is('api/password/update')
                || $request->is('api/v1/ubah-password');

            $isLogoutRoute = $request->routeIs('logout')
                || $request->is('logout')
                || $request->is('api/logout');

            if (! $isPasswordRoute && ! $isLogoutRoute) {
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Wajib mengubah kata sandi bawaan sebelum mengakses layanan.',
                        'must_change_password' => true,
                    ], 403);
                }

                return redirect()->route('siswa.password.form');
            }
        }

        return $next($request);
    }
}
