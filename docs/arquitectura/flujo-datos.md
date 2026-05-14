# Flujo de Datos

## Diagrama de Importación → Base de Datos → Visualización

```
┌─────────────────────────────────────────────────────────────┐
│                     IMPORTACIÓN                              │
│                                                             │
│  Excel ER (multi-hoja) ──→ ERSheetImport ──→ registros META │
│  Excel Ventas (PAR/PE) ──→ VentasDetalladasImport ──→ REAL │
│  PDF ER ──→ PDFERExtractorService ──→ registros REAL        │
│  Excel Surtimiento ──→ SurtimientoTiendasImport ──→ REAL    │
│  Excel Mermas ──→ MermasQuebrantosImport ──→ META           │
│  Formulario ──→ importMermasComprometido ──→ REAL           │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────────┐
│                  BASE DE DATOS                               │
│                                                             │
│  ┌──────────────────────────────────────────────────────┐   │
│  │              registros_financieros                    │   │
│  │  almacen_id │ concepto_id │ anio │ mes │ tipo_dato  │   │
│  │  programa │ monto (cifrado AES-256)                  │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌──────────────┐  ┌──────────────────┐  ┌──────────────┐  │
│  │  almacenes   │  │ conceptos_maestros│  │  poa_notas   │  │
│  └──────────────┘  └──────────────────┘  └──────────────┘  │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────────┐
│                   DOMAIN SERVICES                            │
│                                                             │
│  POADomainService                                           │
│  ├── Consulta: 5 queries masivas (META + REAL + VENTAS)     │
│  ├── Lógica: suma METAs, suma/promedia REALes               │
│  └── Retorno: dataPoa[concepto_id][label] = stdClass        │
│                                                             │
│  ERDomainService                                            │
│  ├── Consulta: registros META por concepto ER               │
│  └── Retorno: dataER[concepto_id]→montos[mes]               │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────────┐
│                   USE CASES                                  │
│                                                             │
│  ObtenerDatosPOA → construye filtros, llama Domain Service  │
│  ObtenerDatosER  → construye filtros, llama Domain Service  │
│  SincronizarPOA  → sincroniza metas POA desde ER            │
└───────────────────────┬─────────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────────┐
│                   CONTROLLERS → VIEWS                        │
│                                                             │
│  GET /poa      → POA index (filtros + tabla)                │
│  GET /poa/export → Descarga Excel/PDF con plantilla         │
│  GET /estado-resultados → Tabla ER con 12 meses             │
│  GET /         → Dashboard con indicadores                  │
└─────────────────────────────────────────────────────────────┘
```

## Tipo de Dato: META vs REAL

| tipo_dato | Descripción | Origen |
|---|---|---|
| `META` | Presupuesto comprometido | Importación Excel ER / Mermas |
| `REAL` | Ejecución real | Importación Ventas / PDF / Surtimiento / Formulario |

Los conceptos con `unidad_medida` = 'PORCENTAJE' (Oportunidad, Eficiencia) tienen META siempre = 100.

## Relación ER → POA

Los compromisos POA pueden vincularse a conceptos ER mediante el campo `concepto_er_nombre` en `conceptos_maestros`. Cuando existe este vínculo, el POA usa las METAs del ER como referencia.
