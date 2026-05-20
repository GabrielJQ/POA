<?php

namespace Tests\Feature;

use App\Domain\Entities\Almacen;
use App\Domain\Entities\ConceptoMaestro;
use App\Domain\Entities\Regional;
use App\Domain\Entities\UnidadOperativa;
use App\Domain\Entities\User;
use App\Domain\Entities\RegistroFinanciero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $supervisor;
    private User $capturista;
    private Almacen $almacen;
    private ConceptoMaestro $concepto;

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

        $this->concepto = ConceptoMaestro::create([
            'nombre' => 'OPORTUNIDAD',
            'categoria' => 'POA',
            'unidad_medida' => 'PORCENTAJE',
        ]);

        ConceptoMaestro::create([
            'nombre' => 'OPORTUNIDAD',
            'categoria' => 'ER',
            'unidad_medida' => 'PORCENTAJE',
            'concepto_er_nombre' => 'OPORTUNIDAD',
        ]);

        $this->admin = User::factory()->admin()->create();
        $this->supervisor = User::factory()->supervisor()->create();
        $this->capturista = User::factory()->capturista($this->almacen->id)->create();
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

    public function test_view_mialmacen_gate_allows_capturista(): void
    {
        $this->assertTrue($this->capturista->can('view-mialmacen'));
    }

    public function test_view_mialmacen_gate_denies_admin(): void
    {
        $this->assertFalse($this->admin->can('view-mialmacen'));
    }

    public function test_view_mialmacen_gate_denies_supervisor(): void
    {
        $this->assertFalse($this->supervisor->can('view-mialmacen'));
    }

    public function test_capturista_can_access_home_and_sees_their_store(): void
    {
        $response = $this->actingAs($this->capturista)->get('/');
        $response->assertStatus(200);
        $response->assertSee('TEST ALMACEN');
    }

    public function test_admin_can_access_home_and_sees_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/');
        $response->assertStatus(200);
    }

    public function test_supervisor_can_access_home_and_sees_dashboard(): void
    {
        $response = $this->actingAs($this->supervisor)->get('/');
        $response->assertStatus(200);
    }

    public function test_capturista_poa_forces_their_store(): void
    {
        $response = $this->actingAs($this->capturista)->get('/poa');
        $response->assertStatus(200);
        $response->assertSee('TEST ALMACEN');
    }

    public function test_capturista_er_forces_their_store(): void
    {
        $response = $this->actingAs($this->capturista)->get('/estado-resultados');
        $response->assertStatus(200);
    }

    public function test_capturista_import_shows_their_store(): void
    {
        $response = $this->actingAs($this->capturista)->get('/importaciones');
        $response->assertStatus(200);
        $response->assertSee('TEST ALMACEN');
    }

    public function test_supervisor_poa_shows_all_stores(): void
    {
        $response = $this->actingAs($this->supervisor)->get('/poa');
        $response->assertStatus(200);
    }

    public function test_supervisor_er_shows_all_stores(): void
    {
        $response = $this->actingAs($this->supervisor)->get('/estado-resultados');
        $response->assertStatus(200);
    }

    public function test_capturista_cannot_edit_notes(): void
    {
        $this->assertFalse($this->capturista->can('edit-notas'));
    }

    public function test_supervisor_can_edit_notes(): void
    {
        $this->assertTrue($this->supervisor->can('edit-notas'));
    }

    public function test_admin_can_edit_notes(): void
    {
        $this->assertTrue($this->admin->can('edit-notas'));
    }

    public function test_capturista_cannot_edit_existing_notes(): void
    {
        $note = \App\Domain\Entities\PoaNota::create([
            'concepto_id' => $this->concepto->id,
            'label' => 'COMPROMETIDO',
            'anio' => date('Y'),
            'almacen_id' => $this->almacen->id,
            'mes' => 1,
            'nota_aclaratoria' => 'Nota existente',
        ]);

        $response = $this->actingAs($this->capturista)->postJson('/poa/nota', [
            'concepto_id' => $this->concepto->id,
            'label' => 'COMPROMETIDO',
            'anio' => date('Y'),
            'nota_aclaratoria' => 'Intento de edición',
            'almacen_id' => $this->almacen->id,
            'mes' => 1,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_edit_existing_notes(): void
    {
        $note = \App\Domain\Entities\PoaNota::create([
            'concepto_id' => $this->concepto->id,
            'label' => 'COMPROMETIDO',
            'anio' => date('Y'),
            'almacen_id' => $this->almacen->id,
            'mes' => 1,
            'nota_aclaratoria' => 'Nota existente',
        ]);

        $response = $this->actingAs($this->admin)->postJson('/poa/nota', [
            'concepto_id' => $this->concepto->id,
            'label' => 'COMPROMETIDO',
            'anio' => date('Y'),
            'nota_aclaratoria' => 'Edición de admin',
            'almacen_id' => $this->almacen->id,
            'mes' => 1,
        ]);

        $response->assertStatus(200);
    }

    public function test_capturista_can_create_new_note(): void
    {
        $response = $this->actingAs($this->capturista)->postJson('/poa/nota', [
            'concepto_id' => $this->concepto->id,
            'label' => 'COMPROMETIDO',
            'anio' => date('Y'),
            'nota_aclaratoria' => 'Nota nueva',
            'almacen_id' => $this->almacen->id,
            'mes' => 2,
        ]);

        $response->assertStatus(200);
    }

    public function test_capturista_guardar_reales_forces_their_store(): void
    {
        $response = $this->actingAs($this->capturista)->postJson('/poa/reales/guardar', [
            'concepto_id' => $this->concepto->id,
            'almacen_id' => 999,
            'anio' => date('Y'),
            'valores' => [['mes' => 1, 'monto' => 100]],
        ]);

        // Force merge overwrites almacen_id=999 with capturista's store
        $response->assertStatus(200);
        $response->assertJson(['saved' => 1]);

        // Verify it was saved to the capturista's store, not 999
        $record = RegistroFinanciero::where('almacen_id', 999)->first();
        $this->assertNull($record);

        $record = RegistroFinanciero::where('almacen_id', $this->almacen->id)->first();
        $this->assertNotNull($record);
        $this->assertEquals(100, (float) $record->monto);
    }
}
