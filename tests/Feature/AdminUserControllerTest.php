<?php

namespace Tests\Feature;

use App\Domain\Entities\Almacen;
use App\Domain\Entities\Regional;
use App\Domain\Entities\UnidadOperativa;
use App\Domain\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
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

        $this->admin = User::factory()->admin()->create();
    }

    public function test_index_lists_users(): void
    {
        User::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_create_shows_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/users/create');
        $response->assertStatus(200);
        $response->assertSee('Nuevo Usuario');
    }

    public function test_store_creates_capturista(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Nuevo Capturista',
            'email' => 'nuevo@test.com',
            'password' => 'secret123',
            'role' => 'capturista',
            'almacen_id' => $this->almacen->id,
        ]);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $user = User::where('email', 'nuevo@test.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('capturista', $user->role);
        $this->assertEquals($this->almacen->id, $user->almacen_id);
    }

    public function test_store_creates_supervisor_without_almacen(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Nuevo Supervisor',
            'email' => 'super@test.com',
            'password' => 'secret123',
            'role' => 'supervisor',
            'almacen_id' => '',
        ]);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $user = User::where('email', 'super@test.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('supervisor', $user->role);
        $this->assertNull($user->almacen_id);
    }

    public function test_store_validates_almacen_for_capturista(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Capturista Sin Almacen',
            'email' => 'capt@test.com',
            'password' => 'secret123',
            'role' => 'capturista',
            'almacen_id' => '',
        ]);

        $response->assertSessionHasErrors('almacen_id');
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', []);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'role']);
    }

    public function test_edit_shows_form_with_user_data(): void
    {
        $user = User::factory()->capturista($this->almacen->id)->create();

        $response = $this->actingAs($this->admin)->get("/admin/users/{$user->id}/edit");
        $response->assertStatus(200);
        $response->assertSee($user->name);
    }

    public function test_update_modifies_user(): void
    {
        $user = User::factory()->capturista($this->almacen->id)->create([
            'name' => 'Original Name',
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => $user->email,
            'role' => 'supervisor',
            'almacen_id' => '',
        ]);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('supervisor', $user->role);
        $this->assertNull($user->almacen_id);
    }

    public function test_update_changes_password_only_when_provided(): void
    {
        $user = User::factory()->admin()->create([
            'password' => bcrypt('original'),
        ]);

        $this->actingAs($this->admin)->put("/admin/users/{$user->id}", [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 'admin',
            'password' => '',
        ]);

        // Password should remain unchanged
        $this->assertTrue(password_verify('original', $user->fresh()->password));

        $this->actingAs($this->admin)->put("/admin/users/{$user->id}", [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 'admin',
            'password' => 'newpass123',
        ]);

        $this->assertTrue(password_verify('newpass123', $user->fresh()->password));
    }

    public function test_destroy_deletes_user(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/users/{$user->id}");

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $this->assertNull(User::find($user->id));
    }

    public function test_destroy_prevents_self_deletion(): void
    {
        $response = $this->actingAs($this->admin)->delete("/admin/users/{$this->admin->id}");

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('error');

        $this->assertNotNull(User::find($this->admin->id));
    }
}
