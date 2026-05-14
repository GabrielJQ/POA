# POA Module - Session Context

## Completed Tasks (May 2026)

### 1. PDF Extraction Service
- **File**: `app/Domain/Services/PDFERExtractorService.php`
- Rewrote regex: `\.\d+` → `\.\d{2}` to prevent concatenation across columns
- Block 1: 9 stores (AYUTLA MIXES through MAGDALENA OCOTLAN)
- Block 2: TAMAZULAPAN, SANTIAGO TEOTITLAN, VALLES CENTRALES, SANTIAGO MATATLAN
- Mapping: "SANTA MARIA LACHIXIO" → "LACHIXIO"
- Route: `POST /importaciones/pdf-realizado`

### 2. Surtimiento Tiendas Import
- **File**: `app/Imports/SurtimientoTiendasImport.php`
- Reads `CONS 2026.xlsx` (columns B-I: Q1-Q4 × Oportunidad/Eficiencia)
- Normalizes store names
- Route: `POST /importaciones/surtimiento`
- Form: `resources/views/components/importaciones/form-surtimiento.blade.php`
- **Important**: Store full precision (no `round()`) — fixed rounding error where 11.50/3=3.8333 was stored as 3.83, causing quarterly sum 11.49 ≠ 11.50

### 3. POA Domain Service - Major Refactor
- **File**: `app/Domain/Services/POADomainService.php`
- **Performance**: Reduced Supabase queries from ~75 (N+1 per concept) to **5 bulk queries**:
  1. `ConceptoMaestro` where categoria='POA' (compromisos)
  2. `ConceptoMaestro` where categoria='ER' (pluck id by nombre)
  3. `RegistroFinanciero` META for year (grouped by concepto_id)
  4. `RegistroFinanciero` REAL for year (grouped by concepto_id)
  5. `RegistroFinanciero` REAL + LINEA_PRODUCTO (ventas records)
- Response now includes `compromisos` to avoid duplicate query in use case
- Return type: `['compromisos' => Collection, 'dataPoa' => array]`

### 4. Critical Bug Fixes in Consolidado Mode

#### Bug A: META monthly assignment used `break` (only first store)
- **Location**: `buildDataPoa()`, monthly META loop
- **Problem**: `break` after `=` meant only 1 of 14 stores' META was used per month
- **Fix**: Changed `$obj1->$col = (float) $r->monto` with `break` → `$obj1->$col += (float) $r->monto` without `break`
- **Result**: VENTAS PAR META Q1 went from 18M → 183M (correct sum across stores)

#### Bug B: Percentage concepts summed instead of averaged in consolidado
- **Location**: `buildDataPoa()`, REAL processing for non-ventas
- **Problem**: `$totalReal` and `$ventasParPeMes` summed across all stores
- **Fix**: After summing, divide by store count when `$esPorcentaje && !$almacenId`
- **Result**: OPORTUNIDAD went from 259.15% → 21.60% (avg of 12 stores)

#### Bug C: META `mes=0` records (annual aggregate) had no monthly breakdown
- **Location**: `buildDataPoa()`, monthly META fallback
- **Fix**: After monthly loop, check ALL 12 months for any non-zero value. If none found and annual META > 0, set `mes_01 = $obj1->meta_anual` so period avance shows the annual target.

### 5. POA Percentage Display
- **File**: `resources/views/components/poa/tabla.blade.php`
- For PORCENTAJE concepts: `$avancePeriodo1 = 100` (META is always 100)
- Display with 2 decimal places using `number_format`

### 6. Use Case Cleanup
- **File**: `app/Application/UseCases/POA/ObtenerDatosPOA.php`
- Removed redundant `ConceptoMaestro` query for compromisos (uses domain service's result)
- Removed unused `use App\Models\ConceptoMaestro` import

## Database Details
- Table: `registros_financieros`
- Concept ids: 30 (OPORTUNIDAD), 31 (EFICIENCIA) — both categoria='POA'
- ER concept for VENTAS A TIENDAS: id=1
- 72 surtimiento REAL records: 12 stores × 2 concepts × 3 months (Q1) (VALLES CENTRALES no incluido aún — necesita re-import)
- Surtimiento import uses `updateOrCreate` matching on (almacen_id, concepto_id, anio, mes, tipo_dato, programa)

## Store ID Mapping
| id | Store |
|----|-------|
| 1 | ALMACEN CENTRAL OAXACA |
| 2 | AYUTLA MIXES |
| 3 | CUAJIMOLOYAS |
| 4 | SAN JOSE EL CHILAR |
| 5 | IXTLAN DE JUAREZ |
| 6 | SAN PEDRO JUCHATENGO |
| 7 | LACHIXIO |
| 8 | SANTIAGO MATATLAN |
| 9 | MAGDALENA OCOTLAN |
| 10 | SAN ANDRES HIDALGO |
| 11 | SANTIAGO TEOTITLAN |
| 12 | TAMAZULAPAN |
| 13 | VALLES CENTRALES |

### 7. Documentación del Proyecto (Scribe + VitePress)

#### Scribe (Documentación de Endpoints)
- **Instalación**: `composer require --dev knuckleswtf/scribe`
- **Config**: `config/scribe.php` — escanea todas las rutas (`prefixes => ['*']`), protegido con middleware `auth`
- **PHPDoc**: Se agregaron anotaciones `@group`, `@bodyParam`, `@queryParam` a todos los controladores:
  - `ImportController` (index + 7 imports)
  - `PoaController` (index, export, saveNota, sync)
  - `EstadoResultadosController` (index, export, store, import, importPDF)
  - `DashboardController` (index)
  - `MovimientoController` (import)
- **Generación**: `php artisan scribe:generate` o `composer run docs:api`
- **URL**: `/docs` (requiere autenticación)

#### VitePress (Documentación Técnica)
- **Instalación**: `npm install --save-dev vitepress`
- **Estructura**: `docs/` en la raíz del proyecto
- **Contenido**:
  - `docs/index.md` — Home del sitio
  - `docs/guia-rapida.md` — Comandos, estructura del proyecto
  - `docs/arquitectura/index.md` — Clean Architecture, capas, caché
  - `docs/arquitectura/domain-services.md` — POADomainService, ERDomainService, DashboardService, PDFERExtractorService
  - `docs/arquitectura/flujo-datos.md` — Pipeline importación → BD → visualización
  - `docs/modulos/poa.md` — POA: filtros, exportaciones, casos especiales
  - `docs/modulos/estado-resultados.md` — ER: fuentes de datos, matriz, sincronización
  - `docs/modulos/importaciones.md` — Detalle de todos los importers
  - `docs/base-de-datos/esquema.md` — Schema de tablas y relaciones
  - `docs/base-de-datos/store-mapping.md` — Mapeo de IDs y normalización de nombres
- **Scripts**: `npm run docs:dev`, `npm run docs:build`, `npm run docs:preview`
- **Build**: `npx vitepress build docs`

#### Ruta de sincronización agregada
- **Archivo**: `routes/web.php`
- Se agregó `POST /poa/sync` → `PoaController::sync` (existente pero sin ruta)

## Pending / Next Steps
- VALLES CENTRALES ahora es almacén independiente (id=13). Re-importar todos los Excel para separar datos previamente combinados con ALMACEN CENTRAL OAXACA.
- Import Q2, Q3, Q4 data when `CONS 2026.xlsx` is updated (re-run import to update existing records via `updateOrCreate`)
- Verify POA table visually in browser for all filter modes
- META monthly distribution for ER-synced concepts (currently stored as `mes=0` annual aggregate)

## Connection
- Supabase PostgreSQL (cloud), high latency per query — bulk loading is critical for performance
