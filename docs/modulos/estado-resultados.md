# Módulo Estado de Resultados

## Descripción

Gestiona las metas presupuestales mensuales del Estado de Resultados. Los datos alimentan al módulo POA a través del vínculo `concepto_er_nombre`.

## Rutas

| Método | Ruta | Propósito |
|---|---|---|
| GET | `/estado-resultados` | Vista con matriz de 12 meses |
| GET | `/estado-resultados/export` | Descarga Excel |
| POST | `/estado-resultados/store` | Guardar registro manual |
| POST | `/estado-resultados/import-pdf` | Importar PDF |

## Fuentes de Datos

### 1. Excel ER (multi-hoja)
- Un archivo Excel con una hoja por almacén
- Cada hoja: filas = conceptos ER, columnas D-O = meses (Enero-Diciembre)
- Los nombres de hoja se mapean a almacenes
- Guarda como `tipo_dato = META`

### 2. PDF ER
- PDF con Estado de Resultados de todas las tiendas
- Extrae: TOTAL DE GTOS DE DISTRIBUCION y RESULTADO DIRECTO DE OPERACIÓN
- Guarda como `tipo_dato = REAL`

### 3. Captura Manual
- Formulario para guardar registros individuales
- Útil para ajustes o datos faltantes

## Estructura de la Matriz

La matriz ER se construye con:
- **Filas**: Conceptos ER (ordenados por campo `orden`)
- **Columnas**: 12 meses + total anual
- **Valor**: Monto META del periodo

## Sincronización con POA

Cuando se importa un ER, el Use Case `ImportarER` sincroniza automáticamente las metas POA llamando a `SincronizarPOA`.

## Conceptos ER

Los conceptos se almacenan en `conceptos_maestros` con `categoria = 'ER'`. Algunos conceptos tienen `es_titulo = true` (GASTOS DE DISTRIBUCIÓN) para agrupación visual.
