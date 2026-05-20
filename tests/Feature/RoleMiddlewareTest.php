<?php

namespace Tests\Feature;

use App\Domain\Entities\Almacen;
use App\Domain\Entities\Regional;
use App\Domain\Entities\UnidadOperativa;
use App\Domain\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $supervisor;
    private User $capturista;

    protected function setUp(): void
    {
        parent::setUp();

        $regional = Regional::create(['nombre' => 'TEST REGIONAL']);
        $uo = UnidadOperativa::create([
            'nombre' => 'TEST UO',
            'regional_id' => $regional->id,
        ]);
        $almacen = Almacen::create([
            'nombre' => 'TEST ALMACEN',
            'numero_almacen' => '999',
            'unidad_operativa_id' => $uo->id,
        ]);

        $this->admin = User::factory()->admin()->create();
        $this->supervisor = User::factory()->supervisor()->create();
        $this->capturista = User::factory()->capturista($almacen->id)->create();
    }

    public function test_admin_can_access_admin_users_route(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_supervisor_cannot_access_admin_users_route(): void
    {
        $response = $this->actingAs($this->supervisor)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_capturista_cannot_access_admin_users_route(): void
    {
        $response = $this->actingAs($this->capturista)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_dashboard_view_gate_allows_admin(): void
    {
        $this->assertTrue($this->admin->can('view-dashboard'));
    }

    public function test_dashboard_view_gate_allows_supervisor(): void
    {
        $this->assertTrue($this->supervisor->can('view-dashboard'));
    }

    public function test_dashboard_view_gate_denies_capturista(): void
    {
        $this->assertFalse($this->capturista->can('view-dashboard'));
    }

    public function test_manage_users_gate_allows_admin(): void
    {
        $this->assertTrue($this->admin->can('manage-users'));
    }

    public function test_manage_users_gate_denies_supervisor(): void
    {
        $this->assertFalse($this->supervisor->can('manage-users'));
    }

    public function test_manage_users_gate_denies_capturista(): void
    {
        $this->assertFalse($this->capturista->can('manage-users'));
    }

    public function test_edit_notas_gate_allows_admin(): void
    {
        $this->assertTrue($this->admin->can('edit-notas'));
    }

    public function test_edit_notas_gate_allows_supervisor(): void
    {
        $this->assertTrue($this->supervisor->can('edit-notas'));
    }

    public function test_edit_notas_gate_denies_capturista(): void
    {
        $this->assertFalse($this->capturista->can('edit-notas'));
    }
}
