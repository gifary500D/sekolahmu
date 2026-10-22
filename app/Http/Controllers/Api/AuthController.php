<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\AuthenticatesUsersWithDualLogin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use AuthenticatesUsersWithDualLogin;

    /**
     * Endpoint login API (Mendukung Email atau NISN)
     */
    public function login(Request $request): JsonResponse
    {
        $loginInput = trim((string) ($request->input('login') ?? $request->input('email') ?? $request->input('nisn')));
        $password = (string) $request->input('password');

        $validator = Validator::make([
            'login' => $loginInput,
            'password' => $password,
        ], [
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Email atau NISN wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Auto-provisioning demo account if needed
        $this->provisionDemoAccountIfNeeded($loginInput, $password);

        $user = $this->findUserByLogin($loginInput);

        if (! $user || ! Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email / NISN atau kata sandi yang Anda masukkan salah.',
                'errors' => [
                    'login' => ['Email / NISN atau kata sandi yang Anda masukkan salah.'],
                ],
            ], 401);
        }

        // Verifikasi status SPMB untuk siswa baru
        if ($user->isSiswa() && ! $user->isSpmbDiterima()) {
            $spmb = $user->getSpmb();
            $status = $spmb ? $spmb->status : 'Belum Diterima';

            return response()->json([
                'success' => false,
                'message' => 'Akun Anda belum dapat mengakses dashboard siswa. Status pendaftaran SPMB Anda saat ini: "'.$status.'". Akses dashboard hanya dibuka setelah status dinyatakan "Diterima".',
                'spmb_status' => $status,
            ], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'nisn' => $user->nisn,
                    'role' => $user->role,
                    'kelas_id' => $user->kelas_id,
                    'password_changed' => (bool) $user->password_changed,
                    'must_change_password' => ! $user->password_changed,
                    'spmb_status' => $user->getSpmb()?->status ?? 'Diterima',
                ],
            ],
        ], 200);
    }

    /**
     * Endpoint info pengguna terautentikasi (GET /api/user)
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('kelas');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'nisn' => $user->nisn,
                'role' => $user->role,
                'kelas' => $user->kelas,
                'password_changed' => (bool) $user->password_changed,
                'must_change_password' => ! $user->password_changed,
                'spmb_status' => $user->getSpmb()?->status ?? 'Diterima',
            ],
        ], 200);
    }

    /**
     * Endpoint logout API (POST /api/logout)
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            $token = $user->currentAccessToken();
            if ($token && method_exists($token, 'delete')) {
                $token->delete();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ], 200);
    }

    /**
     * Endpoint ubah kata sandi wajib / berkala (POST /api/ubah-password)
     */
    public function ubahPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->password),
            'password_changed' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi berhasil diperbarui. Selamat datang di Portal Siswa!',
            'data' => [
                'password_changed' => true,
            ],
        ], 200);
    }
}
