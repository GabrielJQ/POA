# Guía Rápida

## Comandos Útiles

### Documentación

```bash
# Generar documentación de endpoints (Scribe)
php artisan scribe:generate

# Servir documentación técnica localmente (VitePress)
npm run docs:dev

# Build de documentación técnica
npm run docs:build
```

### Importación de Datos

```bash
# Todas las importaciones se hacen desde el Centro de Importación
# URL: /importaciones
```

**Tipos de importación:**

| Tipo | Formato | Ruta |
|---|---|---|
| Estado de Resultados (META) | Excel (.xlsx) | POST /importaciones/er |
| Ventas Detalladas (REAL) | Excel (.xlsx) | POST /importaciones/ventas |
| PDF Realizado (REAL) | PDF | POST /importaciones/pdf-realizado |
| Surtimiento a Tiendas (REAL) | Excel (.xlsx) | POST /importaciones/surtimiento |
| Mermas y Quebrantos (META) | Excel (.xlsx) | POST /importaciones/mermas |

### Cache

El sistema usa caché intensivamente. Para forzar recarga después de imports:

```php
// Automático — cada import incrementa 'poa_cache_version'
Cache::increment('poa_cache_version');
```

### Testing

```bash
composer test
```

## Estructura del Proyecto

```
app/
├── Application/UseCases/     # Casos de uso (Clean Architecture)
│   ├── ER/                   #   ObtenerDatosER, ImportarER, GuardarRegistroER
│   └── POA/                  #   ObtenerDatosPOA, SincronizarPOA
├── Domain/
│   ├── Services/             # Lógica de negocio
│   │   ├── POADomainService.php
│   │   ├── ERDomainService.php
│   │   ├── DashboardService.php
│   │   └── PDFERExtractorService.php
│   └── ValueObjects/         # FiltrosPOA, FiltrosER, Periodo
├── Exports/                  # POAExportService, ERExport
├── Http/Controllers/        # Controladores web
├── Imports/                  # Importadores Excel/PDF
└── Models/                   # Eloquent models
```
