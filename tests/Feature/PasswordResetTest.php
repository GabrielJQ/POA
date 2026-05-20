<?php

namespace Tests\Feature;

use App\Domain\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->admin()->create();
    }

    public function test_forgot_password_page_loads(): void
    {
        $response = $this->get('/password/reset');
        $response->assertStatus(200);
        $response->assertSee('RESTABLECER CONTRASEÑA');
    }

    public function test_send_reset_link_for_valid_email(): void
    {
        $response = $this->post('/password/email', [
            'email' => $this->user->email,
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $this->user->email,
        ]);
    }

    public function test_send_reset_link_fails_for_invalid_email(): void
    {
        $response = $this->post('/password/email', [
            'email' => 'noexiste@test.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_reset_form_loads_with_token(): void
    {
        $token = Password::broker()->createToken($this->user);

        $response = $this->get("/password/reset/{$token}");
        $response->assertStatus(200);
        $response->assertSee('NUEVA CONTRASEÑA');
    }

    public function test_can_reset_password_with_valid_token(): void
    {
        $token = Password::broker()->createToken($this->user);

        $response = $this->post('/password/reset', [
            'token' => $token,
            'email' => $this->user->email,
            'password' => 'NuevaPass123!',
            'password_confirmation' => 'NuevaPass123!',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        // Verify new password works
        $this->assertTrue(Hash::check('NuevaPass123!', $this->user->fresh()->password));
    }

    public function test_cannot_reset_with_invalid_token(): void
    {
        $response = $this->post('/password/reset', [
            'token' => 'token-invalido',
            'email' => $this->user->email,
            'password' => 'NuevaPass123!',
            'password_confirmation' => 'NuevaPass123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_reset_validates_password_confirmation(): void
    {
        $token = Password::broker()->createToken($this->user);

        $response = $this->post('/password/reset', [
            'token' => $token,
            'email' => $this->user->email,
            'password' => 'NuevaPass123!',
            'password_confirmation' => 'otra-cosa',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
