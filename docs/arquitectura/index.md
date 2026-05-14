# Arquitectura del Sistema

## Clean Architecture

El proyecto sigue una arquitectura limpia en capas:

```
HTTP (Controllers) → Use Cases → Domain Services → Models (Eloquent)
```

### Capas

| Capa | Responsabilidad | Directorio |
|---|---|---|
| **Controllers** | Validación HTTP, respuesta, inyección de dependencias | `app/Http/Controllers/` |
| **Use Cases** | Orquestar lógica de negocio, coordinar servicios | `app/Application/UseCases/` |
| **Domain Services** | Lógica de negocio pura, consultas a BD con caché | `app/Domain/Services/` |
| **Value Objects** | Objetos de valor inmutables (Filtros, Períodos) | `app/Domain/ValueObjects/` |
| **Models** | Eloquent ORM, relationships, accesors | `app/Models/` |

### Flujo de una Petición Típica

```
1. Request HTTP → Controller
2. Controller construye Value Objects desde request
3. Controller llama Use Case
4. Use Case llama Domain Service
5. Domain Service consulta Models (con caché)
6. Datos retornan → Controller → View
```

## Diagrama de Módulos

```
Dashboard
  └── DashboardService (índice de eficiencia)

Estado de Resultados
  ├── ERDomainService (consulta metas ER)
  └── PDFERExtractorService (extracción de PDF)

POA
  ├── POADomainService (cálculo de metas vs real, consolidado)
  ├── POAExportService (descarga Excel/PDF)
  └── SincronizarPOA (sincronización desde ER)

Importaciones
  ├── ERSheetImport (Excel META por hoja/almacén)
  ├── VentasDetalladasImport (Excel REAL por línea de producto)
  ├── SurtimientoTiendasImport (Excel REAL oportunidad/eficiencia)
  └── MermasQuebrantosImport (Excel META tasas sobre ventas)
```

## Estrategia de Caché

Todas las consultas pesadas se cachean con `Cache::remember()`:

| Clave | TTL | Propósito |
|---|---|---|
| `almacenes_ordenados` | 24h | Lista de almacenes |
| `conceptos_poa` | 24h | Conceptos categoría POA |
| `conceptos_er` | 24h | Conceptos categoría ER |
| `conceptos_er_pluck` | 24h | Pluck de conceptos ER |
| `conceptos_lp_ids` | 24h | IDs de líneas de producto |
| `poa_data_{...}` | 5min | Datos POA calculados |
| `er_data_{...}` | 5min | Datos ER calculados |
| `dashboard_data_{...}` | 5min | Dashboard |

**Invalidación**: Cada import incrementa `poa_cache_version`, lo que cambia la clave de caché de datos calculados (POA, ER, Dashboard).
