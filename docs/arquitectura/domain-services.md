# Servicios de Dominio

## POADomainService

**Archivo**: `app/Domain/Services/POADomainService.php`

Servicio principal que consolida los datos del POA. Originalmente tenía N+1 queries por concepto (~75 queries); se optimizó a **5 queries masivas**:

1. `ConceptoMaestro` donde `categoria='POA'` (compromisos)
2. `ConceptoMaestro` donde `categoria='ER'` (pluck id por nombre)
3. `RegistroFinanciero` META para el año (agrupado por concepto_id)
4. `RegistroFinanciero` REAL para el año (agrupado por concepto_id)
5. `RegistroFinanciero` REAL + LINEA_PRODUCTO (ventas)

### Método Principal

```php
obtenerDatosPOA(FiltrosPOA $filtros): array
```

Retorna `['compromisos' => Collection, 'dataPoa' => array]`.

### Lógica de Consolidado

Cuando no se especifica `almacen_id` (modo consolidado):
- **METAs**: Se suman todos los almacenes
- **REAL para porcentajes**: Se promedian (suma / número de almacenes)
- **REAL para montos**: Se suman

### Bugs Corregidos

1. **META mensual con `break`**: Solo asignaba META del primer almacén → corregido a `+=` sin `break`
2. **Porcentajes sumados**: Oportunidad mostraba 259% → corregido a promedio
3. **META anual sin desglose mensual**: Si no hay datos mensuales pero hay meta anual, asigna a `mes_01`

## ERDomainService

**Archivo**: `app/Domain/Services/ERDomainService.php`

Gestiona los datos del Estado de Resultados. Consulta registros META de la categoría ER y construye una matriz mes x concepto.

```php
obtenerDatosER(FiltrosER $filtros): array  // Matriz de conceptos con montos mensuales
obtenerConceptosER(): array                 // Lista de conceptos ER
guardarManual(array $datos): void           // Guardar registro individual
```

## DashboardService

**Archivo**: `app/Domain/Services/DashboardService.php`

Calcula el índice de eficiencia por almacén:
- Itera almacenes × compromisos POA
- Calcula % de logro (real/meta)
- Promedia los logros por almacén
- Clasifica: < 30% rojo, < 50% atención
- Retorna top 3, bottom 3, indicador consolidado

## PDFERExtractorService

**Archivo**: `app/Domain/Services/PDFERExtractorService.php`

Extrae datos del PDF de Estado de Resultados.

### Bloques de Tiendas

**Bloque 1** (9 tiendas): ALMACEN CENTRAL OAXACA, AYUTLA MIXES, CUAJIMOLOYAS, IXTLAN DE JUAREZ, MAGDALENA OCOTLAN, SAN ANDRES HIDALGO, SAN JOSE EL CHILAR, SAN PEDRO JUCHATENGO, LACHIXIO

**Bloque 2** (4 tiendas): TAMAZULAPAN, SANTIAGO TEOTITLAN, VALLES CENTRALES, SANTIAGO MATATLAN

### Conceptos Extraldos

| Texto en PDF | Nombre en BD |
|---|---|
| TOTAL GASTOS DE DISTRIBUCION | TOTAL DE GTOS DE DISTRIBUCION |
| RESULTADO DIRECTO DE OPERACION | RESULTADO DIRECTO DE OPERACIÓN |

### Proceso

1. Detecta mes por nombre en el texto (ENERO, FEBRERO, ...)
2. Busca líneas con los conceptos mapeados
3. Por cada bloque, extrae números con regex (`/-?\d{1,3}(?:,\d{3})*(?:\.\d{2})?/`)
4. Escala valores (miles → pesos, ×1000)
5. Guarda con `updateOrCreate` por (almacen_id, concepto_id, anio, mes, tipo_dato, programa)
