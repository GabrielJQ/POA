# Módulo POA

## Descripción

El **Programa Anual de Trabajo (POA)** compara metas comprometidas contra ejecución real para cada concepto, por almacén o en consolidado.

## Rutas

| Método | Ruta | Propósito |
|---|---|---|
| GET | `/poa` | Vista principal con filtros |
| GET | `/poa/export` | Descarga Excel o PDF |
| POST | `/poa/nota` | Guardar nota aclaratoria |

## Filtros

| Parámetro | Valores | Default |
|---|---|---|
| `anio` | 2000-2100 | Año actual |
| `almacen_id` | ID numérico o vacío (consolidado) | Consolidado |
| `periodo` | `mensual`, `trimestral`, `anual` | `mensual` |
| `mes` | 1-12 | Mes actual |
| `trimestre` | 1-4 | Según mes actual |

## Estructura de la Tabla

Cada concepto POA tiene 2 filas:
- **Fila 1** (label_fila_1, ej. "COMPROMETIDO"): META
- **Fila 2** (label_fila_2, ej. "REALIZADO"): REAL

Columnas: Concepto | Unidad | Meta Anual | Avance Período | % Período | % Anual | Notas

## Casos Especiales

### Conceptos Porcentaje (Oportunidad, Eficiencia)
- META siempre = 100
- Avance del período siempre = 100
- % de logro = Real / 100

### Ventas (Presupuesto de Venta PAR/PE)
- Las METAs vienen del ER (concepto VENTAS A TIENDAS, id=1)
- Los REALes vienen de registros con programa PAR o PE y línea de producto

### Notas Aclaratorias
- Se guardan por concepto, almacén, año y mes
- Soporte para mes (1-12), trimestre (101-104) y anual (0)
- Se muestran en la tabla y en exportaciones

## Exportaciones

### Excel (.xlsx)
- Usa plantilla en `FORMATO POA VACIO.xlsx`
- Llena encabezados (almacén, período, tipo de avance)
- Escribe 2 filas por concepto (Comprometido + Realizado)
- Formato de porcentaje con 2 decimales

### PDF
- Renderiza vista Blade `poa.pdf` con DomPDF
- Horizontal, tamaño tabloide
- Mismos datos que Excel
