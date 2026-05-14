<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

class POAExportService
{
    private string $templatePath;

    public function __construct()
    {
        $this->templatePath = 'C:\GABOITO\GABO ITO\Alimentacion para el bienestar\POA\FORMATO POA VACIO.xlsx';
    }

    public function download(string $tipo, array $data, array $filters)
    {
        $anio = $filters['anio'] ?? date('Y');
        $almacenNombre = $this->getAlmacenName($filters);
        $periodoLabel = $data['labelPeriodo'] ?? 'ENERO';
        $baseName = "POA_{$anio}_{$almacenNombre}_{$periodoLabel}";
        $baseName = preg_replace('/[^A-Za-z0-9_\- ]/', '', $baseName);

        if ($tipo === 'pdf') {
            $compromisos = $data['compromisos'] ?? collect();
            $dataPoa = $data['dataPoa'] ?? [];
            $html = view('poa.pdf', compact('compromisos', 'dataPoa', 'filters', 'data'))->render();

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('tabloid', 'landscape');
            $dompdf->render();

            $content = $dompdf->output();
            $contentType = 'application/pdf';
            $extension = 'pdf';
        } else {
            $spreadsheet = IOFactory::load($this->templatePath);
            $sheet = $spreadsheet->getActiveSheet();
            $this->fillHeader($sheet, $filters, $data);
            $this->fillData($sheet, $data, $filters);

            $writer = new XlsxWriter($spreadsheet);
            $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            $extension = 'xlsx';

            ob_start();
            $writer->save('php://output');
            $content = ob_get_clean();
        }

        $fileName = "{$baseName}.{$extension}";

        return response($content, 200, [
            'Content-Type' => $contentType,
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }

    private function fillHeader(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, array $filters, array $data): void
    {
        $almacenNombre = $this->getAlmacenName($filters);
        $sheet->setCellValue('D5', $almacenNombre);

        $periodoTipo = $data['periodoTipo'] ?? 'mensual';
        $labelPeriodo = $data['labelPeriodo'] ?? 'ENERO';

        $tipoLabel = match ($periodoTipo) {
            'trimestral' => 'TRIMESTRAL',
            'anual'      => 'ANUAL',
            default      => 'MENSUAL',
        };
        $sheet->setCellValue('E7', "AVANCE {$tipoLabel}");
        $sheet->setCellValue('E8', $labelPeriodo);
        $sheet->setCellValue('F7', "% DE LOGRO DEL PERIODO");
    }

    private function fillData(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, array $data, array $filters): void
    {
        $compromisos = $data['compromisos'] ?? collect();
        $dataPoa = $data['dataPoa'] ?? [];
        $mesesConfig = $data['config']['meses'] ?? [1];

        $startRow = 10;

        foreach ($compromisos as $idx => $compromiso) {
            $rowComp = $startRow + ($idx * 2);
            $rowReal = $rowComp + 1;

            $fila1 = $dataPoa[$compromiso->id][$compromiso->label_fila_1] ?? null;
            $fila2 = $dataPoa[$compromiso->id][$compromiso->label_fila_2] ?? null;

            if (!$fila1 && !$fila2) continue;

            $esPorcentaje = stripos($compromiso->unidad_medida ?? '', 'PORCENTAJE') !== false;

            $metaAnual1 = $fila1 ? (float) $fila1->meta_anual : 0;
            $metaAnual2 = $fila2 ? (float) $fila2->meta_anual : 0;

            $avance1 = 0;
            foreach ($mesesConfig as $m) {
                $col = 'mes_' . str_pad($m, 2, '0', STR_PAD_LEFT);
                $avance1 += $fila1 ? (float) ($fila1->$col ?? 0) : 0;
            }
            $avance2 = 0;
            foreach ($mesesConfig as $m) {
                $col = 'mes_' . str_pad($m, 2, '0', STR_PAD_LEFT);
                $avance2 += $fila2 ? (float) ($fila2->$col ?? 0) : 0;
            }

            if ($esPorcentaje) {
                $avance1 = 100;
            }

            $pctPeriodo = $avance1 != 0 ? ($avance2 / $avance1) * 100 : 0;
            $pctAnual = $metaAnual1 != 0 ? ($metaAnual2 / $metaAnual1) * 100 : 0;

            $sheet->setCellValue("A{$rowComp}", $compromiso->nombre);
            $sheet->setCellValue("B{$rowComp}", $compromiso->label_fila_1);
            $sheet->setCellValue("C{$rowComp}", $metaAnual1);
            $sheet->setCellValue("D{$rowComp}", $compromiso->unidad_medida);
            $sheet->setCellValue("E{$rowComp}", $avance1/1);
            $sheet->setCellValue("F{$rowComp}", $pctPeriodo);
            $sheet->setCellValue("G{$rowComp}", $pctAnual);

            $notaConcepto = ($fila1->nota_aclaratoria ?? '') ?: ($fila2->nota_aclaratoria ?? '');
            $sheet->setCellValue("H{$rowComp}", $notaConcepto);
            $sheet->mergeCells("H{$rowComp}:H{$rowReal}");

            $sheet->setCellValue("A{$rowReal}", '');
            $sheet->setCellValue("B{$rowReal}", $compromiso->label_fila_2);
            $sheet->setCellValue("C{$rowReal}", $metaAnual2);
            $sheet->setCellValue("D{$rowReal}", '');
            $sheet->setCellValue("E{$rowReal}", $avance2/1);
            $sheet->setCellValue("F{$rowReal}", $pctPeriodo);
            $sheet->setCellValue("G{$rowReal}", $pctAnual);

            $this->applyRowStyles($sheet, $rowComp, $rowReal);
        }
    }

    private function applyRowStyles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, int $rowComp, int $rowReal): void
    {
        $pctFormat = '0.00"%"';

        $sheet->getStyle("F{$rowComp}")->getNumberFormat()->setFormatCode($pctFormat);
        $sheet->getStyle("G{$rowComp}")->getNumberFormat()->setFormatCode($pctFormat);
        $sheet->getStyle("F{$rowReal}")->getNumberFormat()->setFormatCode($pctFormat);
        $sheet->getStyle("G{$rowReal}")->getNumberFormat()->setFormatCode($pctFormat);

        $sheet->getStyle("C{$rowComp}")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("C{$rowReal}")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("E{$rowComp}")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("E{$rowReal}")->getNumberFormat()->setFormatCode('#,##0.00');
    }

    private function getAlmacenName(array $filters): string
    {
        if (!empty($filters['mostrarConsolidado'])) {
            return 'CONSOLIDADO';
        }
        if (!empty($filters['almacenSeleccionado'])) {
            $almacen = \App\Models\Almacen::find($filters['almacenSeleccionado']);
            if ($almacen) {
                return $almacen->nombre;
            }
        }
        return 'CONSOLIDADO';
    }
}
