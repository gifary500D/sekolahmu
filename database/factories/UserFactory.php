<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'siswa',
            'kelas_id' => null,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => ['email_verified_at' => null]);
    }

    public function admin(): static
    {
        return $this->state(fn () => ['role' => 'admin']);
    }

    public function guru(): static
    {
        return $this->state(fn () => ['role' => 'guru']);
    }

    public function kepalaSekolah(): static
    {
        return $this->state(fn () => ['role' => 'kepala_sekolah']);
    }

    public function siswa(?int $kelasId = null): static
    {
        return $this->state(fn () => ['role' => 'siswa', 'kelas_id' => $kelasId]);
    }
}
