<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use App\Domain\Contracts\Repositories\IAlmacenRepository;

class POAExportService
{
    private IAlmacenRepository $almacenRepo;

    public function __construct(IAlmacenRepository $almacenRepo)
    {
        $this->almacenRepo = $almacenRepo;
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
            $spreadsheet = $this->buildTemplate();
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

    private function buildTemplate(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Hoja1');

        $centerCenter = Alignment::HORIZONTAL_CENTER . '|' . Alignment::VERTICAL_CENTER;
        $centerBottom = Alignment::HORIZONTAL_CENTER . '|' . Alignment::VERTICAL_BOTTOM;

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(31.45);
        $sheet->getColumnDimension('B')->setWidth(26.63);
        $sheet->getColumnDimension('C')->setWidth(17.63);
        $sheet->getColumnDimension('D')->setWidth(18.45);
        $sheet->getColumnDimension('E')->setWidth(23.63);
        $sheet->getColumnDimension('F')->setWidth(19.18);
        $sheet->getColumnDimension('G')->setWidth(15.91);
        $sheet->getColumnDimension('H')->setWidth(33.09);

        $thin = Border::BORDER_THIN;
        $double = Border::BORDER_DOUBLE;

        // ==================== HEADER ROWS 1-5 ====================

        $headerFont = ['name' => 'Arial', 'size' => 12, 'bold' => true];
        $headerStyle = [
            'font' => $headerFont,
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_BOTTOM],
        ];

        foreach ([1, 2, 3, 4] as $r) {
            $sheet->mergeCells("A{$r}:H{$r}");
            $sheet->getStyle("A{$r}")->applyFromArray($headerStyle);
        }

        $sheet->setCellValue('A1', 'ALIMENTACION PARA EL BIENESTAR');
        $sheet->setCellValue('A2', 'DIRECCIÓN DE OPERACIONES');
        $sheet->setCellValue('A3', 'GERENCIA DE EVALUACIÓN Y PARTICIPACIÓN COMUNITARIA');
        $sheet->setCellValue('A4', 'AVANCES DE PROGRAMA ANUAL DE TRABAJO 2026');

        // Row 5
        $sheet->mergeCells('C5:D5');
        $sheet->setCellValue('A5', 'SUCURSAL:');
        $sheet->setCellValue('B5', 'OAXACA');
        $sheet->setCellValue('C5', 'ALMACEN:  ');
        $row5Style = [
            'font' => ['name' => 'Arial', 'size' => 12, 'bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_BOTTOM],
        ];
        foreach (['A', 'B', 'C'] as $col) {
            $sheet->getStyle("{$col}5")->applyFromArray($row5Style);
        }

        // Row 6 blank

        // ==================== COLUMN HEADERS ROWS 7-8 ====================

        $colHeaderStyle = [
            'font' => ['name' => 'Arial', 'size' => 12, 'bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C0C0C0']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
        ];

        // Merges
        $sheet->mergeCells('A7:B8');
        $sheet->mergeCells('C7:C8');
        $sheet->mergeCells('D7:D8');
        $sheet->mergeCells('F7:F8');
        $sheet->mergeCells('G7:G8');
        $sheet->mergeCells('H7:H8');

        $sheet->setCellValue('A7', 'COMPROMISO ');
        $sheet->setCellValue('C7', 'META ANUAL          ');
        $sheet->setCellValue('D7', 'UNIDAD DE MEDIDA             ');
        $sheet->setCellValue('E7', 'AVANCE MENSUAL');
        $sheet->setCellValue('F7', '% DE LOGRO DEL MES A REPORTAR     ');
        $sheet->setCellValue('G7', '% DE LOGRO SOBRE LA  META ANUAL  ');
        $sheet->setCellValue('H7', 'NOTA ACLARATORIA      ');
        $sheet->setCellValue('E8', 'ENERO ');

        foreach (range('A', 'H') as $col) {
            $sheet->getStyle("{$col}7")->applyFromArray($colHeaderStyle);
        }
        $sheet->getStyle('E8')->applyFromArray($colHeaderStyle);

        // Borders for row 8
        foreach (range('A', 'H') as $col) {
            $sheet->getStyle("{$col}8")->getBorders()->getBottom()->setBorderStyle($double);
        }
        // E8 has thin top border (original template)
        $sheet->getStyle('E8')->getBorders()->getTop()->setBorderStyle($thin);

        // ==================== SEPARATOR ROW 9 ====================

        $sheet->mergeCells('A9:H9');
        $sheet->getStyle('A9')->getBorders()->getTop()->setBorderStyle($double);
        $sheet->getStyle('A9')->getBorders()->getBottom()->setBorderStyle($thin);

        // ==================== DATA ROWS 10-59 (25 concepts) ====================

        $dataFont = ['name' => 'Arial', 'size' => 10];
        $dataFont12 = ['name' => 'Arial', 'size' => 12];
        $pctFont = ['name' => 'Verdana', 'size' => 10];
        $dataAlign = ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true];
        $dataAlignGeneral = ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true];

        $thinBorder = [
            'borders' => [
                'top' => ['borderStyle' => $thin],
                'bottom' => ['borderStyle' => $thin],
                'left' => ['borderStyle' => $thin],
                'right' => ['borderStyle' => $thin],
            ],
        ];

        for ($i = 0; $i < 25; $i++) {
            $rowComp = 10 + ($i * 2);
            $rowReal = $rowComp + 1;

            // Merged cells for odd row (COMPROMETIDO)
            $sheet->mergeCells("A{$rowComp}:A{$rowReal}");
            $sheet->mergeCells("D{$rowComp}:D{$rowReal}");
            $sheet->mergeCells("F{$rowComp}:F{$rowReal}");
            $sheet->mergeCells("G{$rowComp}:G{$rowReal}");
            $sheet->mergeCells("H{$rowComp}:H{$rowReal}");

            // Labels
            $sheet->setCellValue("B{$rowComp}", 'COMPROMETIDO');
            $sheet->setCellValue("B{$rowReal}", 'REALIZADO');

            // Styles for COMPROMETIDO row
            $sheet->getStyle("A{$rowComp}")->applyFromArray(['font' => ['name' => 'Arial', 'size' => 10, 'bold' => true], 'alignment' => $dataAlign] + $thinBorder);
            $sheet->getStyle("B{$rowComp}")->applyFromArray(['font' => $dataFont, 'alignment' => $dataAlign] + $thinBorder);
            $sheet->getStyle("C{$rowComp}")->applyFromArray(['font' => $dataFont12, 'alignment' => $dataAlign, 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]] + $thinBorder);
            $sheet->getStyle("D{$rowComp}")->applyFromArray(['font' => ['name' => 'Arial', 'size' => 9], 'alignment' => $dataAlign] + $thinBorder);
            $sheet->getStyle("E{$rowComp}")->applyFromArray(['font' => $dataFont12, 'alignment' => $dataAlign, 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]] + $thinBorder);
            $sheet->getStyle("F{$rowComp}")->applyFromArray(['font' => $pctFont, 'alignment' => $dataAlign] + $thinBorder);
            $sheet->getStyle("G{$rowComp}")->applyFromArray(['font' => $pctFont, 'alignment' => $dataAlign] + $thinBorder);
            $sheet->getStyle("H{$rowComp}")->applyFromArray(['font' => $dataFont, 'alignment' => ['horizontal' => Alignment::HORIZONTAL_JUSTIFY, 'vertical' => Alignment::VERTICAL_JUSTIFY, 'wrapText' => true]] + $thinBorder);

            // Styles for REALIZADO row
            $sheet->getStyle("A{$rowReal}")->applyFromArray(['alignment' => $dataAlignGeneral] + $thinBorder);
            $sheet->getStyle("B{$rowReal}")->applyFromArray(['font' => $dataFont, 'alignment' => $dataAlign] + $thinBorder);
            $sheet->getStyle("C{$rowReal}")->applyFromArray(['font' => $dataFont12, 'alignment' => $dataAlign, 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC000']]] + $thinBorder);
            $sheet->getStyle("D{$rowReal}")->applyFromArray(['font' => ['name' => 'Arial', 'size' => 9], 'alignment' => $dataAlign] + $thinBorder);
            $sheet->getStyle("E{$rowReal}")->applyFromArray(['font' => $dataFont12, 'alignment' => $dataAlign, 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC000']]] + $thinBorder);
            $sheet->getStyle("F{$rowReal}")->applyFromArray(['font' => $pctFont, 'alignment' => $dataAlign] + $thinBorder);
            $sheet->getStyle("G{$rowReal}")->applyFromArray(['font' => $pctFont, 'alignment' => $dataAlign] + $thinBorder);
            $sheet->getStyle("H{$rowReal}")->applyFromArray($thinBorder);
        }

        // ==================== NUMBER FORMATS ====================

        for ($i = 0; $i < 25; $i++) {
            $rowComp = 10 + ($i * 2);
            $rowReal = $rowComp + 1;

            $sheet->getStyle("C{$rowComp}")->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle("C{$rowReal}")->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle("E{$rowComp}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("E{$rowReal}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("F{$rowComp}")->getNumberFormat()->setFormatCode('0%');
            $sheet->getStyle("F{$rowReal}")->getNumberFormat()->setFormatCode('0%');
            $sheet->getStyle("G{$rowComp}")->getNumberFormat()->setFormatCode('0%');
            $sheet->getStyle("G{$rowReal}")->getNumberFormat()->setFormatCode('0%');
        }

        // ==================== FOOTER (ROWS 60-70) ====================

        // Row 62: signature titles
        $sheet->mergeCells('A62:C62');
        $sheet->mergeCells('D62:E62');
        $sheet->mergeCells('F62:H62');
        $sheet->setCellValue('A62', 'ELABORÓ');
        $sheet->setCellValue('D62', 'REVISÓ:');
        $sheet->setCellValue('F62', 'AUTORIZÓ: ');

        $footerFont = ['name' => 'Arial', 'size' => 10];
        $footerAlign = ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_BOTTOM];
        $footerStyle = [
            'font' => $footerFont,
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
            'alignment' => $footerAlign,
        ];
        foreach (['A', 'D', 'F'] as $col) {
            $sheet->getStyle("{$col}62")->applyFromArray($footerStyle);
        }

        // Row 65: signature names
        $sheet->mergeCells('A65:C65');
        $sheet->mergeCells('F65:H65');
        $sheet->setCellValue('A65', 'LIC. YURI ARIEL SALCIDO MACIAS');
        $sheet->setCellValue('E65', 'LIC. YURI ARIEL SALCIDO MACIAS');
        $sheet->setCellValue('F65', 'LIC. ANDREA DEL ROSARIO URIAS SOLIS');
        foreach (['A', 'E', 'F'] as $col) {
            $sheet->getStyle("{$col}65")->applyFromArray($footerStyle);
        }

        // Row 66: job titles
        $sheet->mergeCells('A66:C66');
        $sheet->mergeCells('F66:H66');
        $sheet->setCellValue('A66', 'RESPONSABLE DE OPERACIONES');
        $sheet->setCellValue('E66', 'SUBGERENTE DE OPERACIONES');
        $sheet->setCellValue('F66', 'ENCARGADA DEL DESPACHO DE GERENCIA REGIONAL OAXACA');
        $sheet->getRowDimension('66')->setRowHeight(50);
        $titleAlign = ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER];
        foreach (['A', 'E', 'F'] as $col) {
            $sheet->getStyle("{$col}66")->applyFromArray(['font' => $footerFont, 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']], 'alignment' => $titleAlign]);
        }

        // Row 69-70: final blank block
        $sheet->mergeCells('A69:H70');

        return $spreadsheet;
    }

    private function fillHeader(Worksheet $sheet, array $filters, array $data): void
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

    private function fillData(Worksheet $sheet, array $data, array $filters): void
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

    private function applyRowStyles(Worksheet $sheet, int $rowComp, int $rowReal): void
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
            $almacen = $this->almacenRepo->findById($filters['almacenSeleccionado']);
            if ($almacen) {
                return $almacen->nombre;
            }
        }
        return 'CONSOLIDADO';
    }
}
