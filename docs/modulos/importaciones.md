# Módulo de Importaciones

## Descripción

Centro de importación homologado con drag & drop. Organizado en dos secciones: **Comprometidos (META)** y **Realizados (REAL)**.

## Importaciones Disponibles

### Comprometidos (META)

| Importación | Archivo | Procesamiento |
|---|---|---|
| **Estado de Resultados** | Excel multi-hoja | Cada hoja = un almacén, filas = conceptos ER, columnas = meses |
| **Mermas y Quebrantos** | Excel por almacén | Calcula META = Ventas × tasa (merma + quebranto) por línea de producto |

### Realizados (REAL)

| Importación | Archivo | Procesamiento |
|---|---|---|
| **Ventas PAR/PE** | Excel detallado | Lee columnas de meses por almacén y línea de producto |
| **PDF Realizado** | PDF | Extrae TOTAL GTOS DISTRIBUCION y RESULTADO DIRECTO OPERACIÓN |
| **Surtimiento a Tiendas** | Excel (CONS 2026.xlsx) | Oportunidad y Eficiencia por trimestre, distribuye en 3 meses |
| **Mermas Realizadas** | Formulario manual | Monto trimestral distribuido en 3 meses |

## Detalle por Importador

### ERSheetImport
- Ubicación: `app/Imports/ERSheetImport.php`
- Detecta almacén por nombre de hoja (ej. "PT AYUTLA" → AYUTLA MIXES)
- Mapea conceptos por nombre normalizado (mayúsculas, sin espacios extra)
- Upsert por lotes de 500 para rendimiento
- Columnas: fila 12+, columna A-C = concepto, D-O = enero-diciembre

### VentasDetalladasImport
- Ubicación: `app/Imports/VentasDetalladasImport.php`
- Detecta almacenes por nombre en filas (no por hoja)
- Dos hojas: "PAR" (Abasto Rural) y "ESP" (Programa Especial)
- Crea líneas de producto automáticamente si no existen
- Columnas de meses: enero=3, febrero=4, ... diciembre=17

### SurtimientoTiendasImport
- Ubicación: `app/Imports/SurtimientoTiendasImport.php`
- Lee archivo "CONS 2026.xlsx" con estructura fija
- Columnas: A=almacén, B=OportunidadQ1, C=EficienciaQ1, ... I=EficienciaQ4
- Distribuye valor trimestral / 3 entre los meses del trimestre
- **Sin redondeo**: almacena precisión completa (ej. 11.50/3 = 3.8333...)
- Mapeo de nombres normalizados (AYUTLA MIXE → AYUTLA MIXES, etc.)

### MermasQuebrantosImport
- Ubicación: `app/Imports/MermasQuebrantosImport.php`
- Mapeo de hojas: "PT AYUTLA" → AYUTLA MIXES, etc.
- Lee filas 15-22 (PROGRAMA ABASTO RURAL) con tasas de `config/mermas.php`
- Columnas de ventas $: col E(4)=ENERO, G(6)=FEBRERO, ..., AA(26)=DICIEMBRE
- Guarda como META

### PDFERExtractorService
- Ubicación: `app/Domain/Services/PDFERExtractorService.php`
- Detecta mes por nombre en el texto del PDF
- Dos bloques de tiendas (9 + 4)
- Regex: `/-?\d{1,3}(?:,\d{3})*(?:\.\d{2})?/`
- Escala ×1000 (el PDF muestra valores en miles)
