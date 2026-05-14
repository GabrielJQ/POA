# Store Mapping

## Almacenes

| ID | Nombre | Notas |
|---|---|---|
| 1 | ALMACEN CENTRAL OAXACA | Principal |
| 2 | AYUTLA MIXES | |
| 3 | CUAJIMOLOYAS | |
| 4 | SAN JOSE EL CHILAR | |
| 5 | IXTLAN DE JUAREZ | |
| 6 | SAN PEDRO JUCHATENGO | |
| 7 | LACHIXIO | Mapeado desde SANTA MARIA LACHIXIO |
| 8 | SANTIAGO MATATLAN | |
| 9 | MAGDALENA OCOTLAN | |
| 10 | SAN ANDRES HIDALGO | |
| 11 | SANTIAGO TEOTITLAN | |
| 12 | TAMAZULAPAN | |
| 13 | VALLES CENTRALES | Separado de ALMACEN CENTRAL OAXACA |

## Normalización de Nombres en Importaciones

### SurtimientoTiendasImport
| Excel | Base de Datos |
|---|---|
| AYUTLA MIXE | AYUTLA MIXES |
| SN ANDRES HIDALGO. | SAN ANDRES HIDALGO |
| EL CHILAR | SAN JOSE EL CHILAR |
| JUCHATENGO | SAN PEDRO JUCHATENGO |
| SANTA MA. LACHIXIO | LACHIXIO |
| TAMAZULAPAM | TAMAZULAPAN |
| TEOTITLAN DE F.M. | SANTIAGO TEOTITLAN |

### MermasQuebrantosImport
| Hoja Excel | Base de Datos |
|---|---|
| PT AYUTLA | AYUTLA MIXES |
| PT CHILAR | SAN JOSE EL CHILAR |
| PT CUAJIMOLOYAS | CUAJIMOLOYAS |
| PT IXTLAN | IXTLAN DE JUAREZ |
| PT JUCHATENGO | SAN PEDRO JUCHATENGO |
| PT LACHIXIO | LACHIXIO |
| PT MATATLAN | SANTIAGO MATATLAN |
| PT MAGDALENA OCOTLAN | MAGDALENA OCOTLAN |
| PT SAN ANDRES | SAN ANDRES HIDALGO |
| PT TAMAZULAPAN | TAMAZULAPAN |
| PT TEOTITLAN | SANTIAGO TEOTITLAN |
| PT VALLES | VALLES CENTRALES |

### ERSheetImport
- Detecta almacén por nombre de hoja (limpia prefijos "PT ", sufijos " PROFORMA", " CONSOLIDADO")
- Fallback: celda D5 del Excel como nombre de almacén
- Casos especiales: hoja "1" → almacén id=1, "VALLES" → VALLES CENTRALES
