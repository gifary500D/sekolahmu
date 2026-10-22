<?php

namespace App\Http\Middleware;

use App\Models\Spmb;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSpmbDiterima
{
    /**
     * Tangani request yang masuk.
     * Memastikan akun siswa hanya dapat mengakses dashboard dan fitur portal siswa
     * setelah status pendaftaran SPMB dinyatakan "Diterima".
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isSiswa()) {
            if (! $user->isSpmbDiterima()) {
                $spmb = $user->getSpmb();
                $status = $spmb ? $spmb->status : 'Belum Diterima';

                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Akses dashboard ditolak. Status SPMB belum "Diterima" (Status saat ini: '.$status.').',
                        'spmb_status' => $status,
                    ], 403);
                }

                abort(403, 'Akses ditolak: Akun siswa baru hanya dapat mengakses dashboard setelah status SPMB dinyatakan "Diterima". Status Anda saat ini: '.$status.'.');
            }
        }

        return $next($request);
    }
}
