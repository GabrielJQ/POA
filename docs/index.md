# POA — Programa Anual de Trabajo

Sistema para la gestión, importación y visualización del **Programa Anual de Trabajo (POA)** y **Estado de Resultados (ER)** de DICONSA Oaxaca.

## Stack Tecnológico

| Componente | Tecnología |
|---|---|
| Backend | Laravel 12 (PHP 8.2) |
| Frontend | Livewire 4, AdminLTE 3, Tailwind CSS 4 |
| Base de Datos | Supabase PostgreSQL |
| Importación | PhpSpreadsheet, Smalot PDF Parser, maatwebsite/Laravel Excel |
| Exportación | DomPDF, PhpSpreadsheet |
| Documentación | Scribe (endpoints), VitePress (arquitectura) |

## Módulos Principales

- **[Dashboard](/modulos/poa)** — Indicadores de eficiencia por almacén
- **[Estado de Resultados](/modulos/estado-resultados)** — Metas presupuestales mensuales por concepto ER
- **[POA](/modulos/poa)** — Programa Anual de Trabajo con metas vs realizado
- **[Centro de Importación](/modulos/importaciones)** — Importación de datos desde Excel y PDF

## Enlaces Rápidos

| Recurso | URL |
|---|---|
| Documentación de Endpoints | `/docs` (requiere autenticación) |
| Documentación Técnica | `npm run docs:dev` (local) |
| Código Fuente | `app/` (Clean Architecture) |

## Convenciones del Proyecto

- **Arquitectura**: Clean Architecture (Use Cases → Domain Services → Models)
- **Base de datos**: `registros_financieros` como tabla central con `tipo_dato` = META | REAL
- **Caché**: Redis-based con clave `poa_cache_version` para invalidación
- **Cifrado**: AES-256 en montos de `registros_financieros`
