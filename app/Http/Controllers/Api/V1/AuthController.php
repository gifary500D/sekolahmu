<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $user = User::where('email', $data['email'])->first();

        // Pesan sengaja sama untuk email salah maupun kata sandi salah.
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau kata sandi salah.'],
            ]);
        }

        $token = $user->createToken('api', ['*'], now()->addDays(7))->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token,
                'tipe' => 'Bearer',
                'user' => $this->ringkasUser($user),
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['data' => $this->ringkasUser($request->user())]);
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();
        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return response()->json(['message' => 'Berhasil keluar.']);
    }

    private function ringkasUser(User $user): array
    {
        return [
            'id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'kelas_id' => $user->kelas_id,
        ];
    }
}
