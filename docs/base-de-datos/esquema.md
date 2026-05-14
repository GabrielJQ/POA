# Esquema de Base de Datos

## Tabla: `registros_financieros` (Central)

| Columna | Tipo | Descripción |
|---|---|---|
| `id` | bigint PK | Auto-incremental |
| `almacen_id` | int FK → almacenes.id | Almacén |
| `concepto_id` | int FK → conceptos_maestros.id | Concepto |
| `mes` | int (1-12) | Mes del registro |
| `anio` | int | Año |
| `monto` | decimal(16,2) | Valor cifrado AES-256 |
| `tipo_dato` | varchar | `META` o `REAL` |
| `programa` | varchar nullable | `PAR` (Abasto Rural), `PE` (Programa Especial) o null |

**Unique Key**: (almacen_id, concepto_id, anio, mes, tipo_dato, programa)

## Tabla: `conceptos_maestros`

| Columna | Tipo | Descripción |
|---|---|---|
| `id` | int PK | Auto-incremental |
| `nombre` | varchar | Nombre del concepto |
| `categoria` | varchar | `POA`, `ER`, o `LINEA_PRODUCTO` |
| `concepto_er_nombre` | varchar nullable | Nombre del concepto ER vinculado (para POA) |
| `unidad_medida` | varchar nullable | `PORCENTAJE` o null |
| `orden` | int | Orden de visualización |
| `label_fila_1` | varchar | Etiqueta fila 1 (ej. COMPROMETIDO) |
| `label_fila_2` | varchar | Etiqueta fila 2 (ej. REALIZADO) |
| `numero` | int nullable | Número de línea de producto |
| `descripcion` | text nullable | Descripción |

## Tabla: `almacenes`

| Columna | Tipo | Descripción |
|---|---|---|
| `id` | int PK | 1-13 |
| `unidad_operativa_id` | int FK | Unidad operativa |
| `nombre` | varchar | Nombre del almacén |
| `numero_almacen` | varchar nullable | Código externo |

## Tabla: `poa_notas`

| Columna | Tipo | Descripción |
|---|---|---|
| `id` | bigint PK | Auto-incremental |
| `concepto_id` | int FK | Concepto POA |
| `almacen_id` | int nullable FK | Almacén (null = consolidado) |
| `label` | varchar | `COMPROMETIDO` o `REALIZADO` |
| `anio` | int | Año |
| `mes` | int | 1-12 (mes), 101-104 (trimestre), 0 (anual) |
| `nota_aclaratoria` | text | Contenido de la nota |

**Unique Key**: (concepto_id, label, anio, almacen_id, mes)

## Tabla: `unidades_operativas`

| Columna | Tipo | Descripción |
|---|---|---|
| `id` | int PK | Auto-incremental |
| `regional_id` | int FK → regionales.id | Regional |
| `nombre` | varchar | Nombre (ej. OAXACA VALLES CENTRALES) |

## Tabla: `regionales`

| Columna | Tipo | Descripción |
|---|---|---|
| `id` | int PK | Auto-incremental |
| `nombre` | varchar | Nombre (ej. REGIONAL OAXACA) |

## Relaciones

```
Regional 1──N UnidadOperativa 1──N Almacen 1──N RegistroFinanciero
                                                    N──1 ConceptoMaestro
Almacen 1──N PoaNota N──1 ConceptoMaestro
```

## Notas

- Los montos en `registros_financieros` están cifrados con AES-256
- El cifrado/descifrado se maneja en los casts del modelo
- La tabla `poas` existe pero está en desuso (los datos se calculan desde `registros_financieros`)
