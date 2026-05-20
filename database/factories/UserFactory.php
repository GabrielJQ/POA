<?php

namespace Database\Factories;

use App\Domain\Entities\Almacen;
use App\Domain\Entities\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'capturista',
            'almacen_id' => null,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'almacen_id' => null,
        ]);
    }

    public function supervisor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'supervisor',
            'almacen_id' => null,
        ]);
    }

    public function capturista(?int $almacenId = null): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'capturista',
            'almacen_id' => $almacenId ?? Almacen::inRandomOrder()->first()?->id,
        ]);
    }
}
