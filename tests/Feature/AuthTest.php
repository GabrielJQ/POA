<?php

namespace Tests\Feature;

use App\Domain\Entities\Almacen;
use App\Domain\Entities\Regional;
use App\Domain\Entities\UnidadOperativa;
use App\Domain\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private Almacen $almacen;

    protected function setUp(): void
    {
        parent::setUp();

        $regional = Regional::create(['nombre' => 'TEST REGIONAL']);
        $uo = UnidadOperativa::create([
            'nombre' => 'TEST UO',
            'regional_id' => $regional->id,
        ]);
        $this->almacen = Almacen::create([
            'nombre' => 'TEST ALMACEN',
            'numero_almacen' => '999',
            'unidad_operativa_id' => $uo->id,
        ]);
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_admin_can_login_and_redirects_to_home(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_capturista_can_login_and_redirects_to_poa(): void
    {
        User::factory()->capturista($this->almacen->id)->create([
            'email' => 'capturista@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'capturista@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/poa?almacen_id=' . $this->almacen->id);
        $this->assertAuthenticated();
    }

    public function test_supervisor_can_login_and_redirects_to_home(): void
    {
        User::factory()->supervisor()->create([
            'email' => 'supervisor@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'supervisor@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_invalid_credentials_return_error(): void
    {
        $response = $this->post('/login', [
            'email' => 'noexiste@test.com',
            'password' => 'wrong',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout_clears_session(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_user_has_role_helpers(): void
    {
        $admin = User::factory()->admin()->create();
        $supervisor = User::factory()->supervisor()->create();
        $capturista = User::factory()->capturista($this->almacen->id)->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isSupervisor());
        $this->assertFalse($admin->isCapturista());

        $this->assertFalse($supervisor->isAdmin());
        $this->assertTrue($supervisor->isSupervisor());
        $this->assertFalse($supervisor->isCapturista());

        $this->assertFalse($capturista->isAdmin());
        $this->assertFalse($capturista->isSupervisor());
        $this->assertTrue($capturista->isCapturista());
    }

    public function test_capturista_has_almacen_relation(): void
    {
        $capturista = User::factory()->capturista($this->almacen->id)->create();

        $this->assertNotNull($capturista->almacen);
        $this->assertEquals($this->almacen->id, $capturista->almacen->id);
        $this->assertEquals('TEST ALMACEN', $capturista->almacen->nombre);
    }

    public function test_admin_has_null_almacen(): void
    {
        $admin = User::factory()->admin()->create();

        $this->assertNull($admin->almacen_id);
    }

    public function test_authenticated_user_can_access_protected_route(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->get('/poa');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_protected_route(): void
    {
        $response = $this->get('/poa');

        $response->assertRedirect('/login');
    }
}
