<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AuditLogPdfService
{
    private array $offsets = [];
    private string $buffer = '';
    private int $n = 0;
    private array $pages = [];
    private int $page = 0;

    // A4 Landscape dimensions in points (72 points = 1 inch)
    private float $pageWidth = 841.89;
    private float $pageHeight = 595.28;
    private float $marginLeft = 35.0;
    private float $marginRight = 35.0;
    private float $marginTop = 40.0;
    private float $marginBottom = 40.0;
    private float $currentY = 0.0;

    public function generate(Collection $logs, string $actorName = 'Super Administrator'): string
    {
        $this->offsets = [];
        $this->buffer = '';
        $this->n = 0;
        $this->pages = [];
        $this->page = 0;

        $this->startNewPage($actorName);

        $rowNum = 1;
        $rowHeight = 22.0;

        foreach ($logs as $log) {
            // Check if page break is needed
            if ($this->currentY < $this->marginBottom + $rowHeight + 30) {
                $this->startNewPage($actorName, false);
            }

            $this->drawTableRow($log, $rowNum, $this->currentY);
            $this->currentY -= $rowHeight;
            $rowNum++;
        }

        // Draw summary & signature on final page if space allows, or new page
        if ($this->currentY < 120) {
            $this->startNewPage($actorName, false);
        }

        $this->drawSignatureSection($actorName, $this->currentY - 15);

        return $this->buildPdf();
    }

    private function startNewPage(string $actorName, bool $isFirstPage = true): void
    {
        $this->page++;
        $this->pages[$this->page] = '';
        $this->currentY = $this->pageHeight - $this->marginTop;

        $this->drawHeader($actorName, $isFirstPage);
        $this->drawTableHeader();
    }

    private function drawHeader(string $actorName, bool $isFirstPage): void
    {
        $stream = "";

        if ($isFirstPage) {
            // Top Accent Bar (Pink NutriGrow: #e11d48 => R:0.882, G:0.114, B:0.282)
            $stream .= sprintf("0.882 0.114 0.282 rg 0 %.2f %.2f 5 re f\n", $this->pageHeight - 5, $this->pageWidth);

            // Title
            $stream .= "BT /F2 15 Tf 0.1 0.1 0.1 rg " . $this->marginLeft . " " . ($this->currentY) . " Td (KEMENTERIAN KESEHATAN RI - NUTRIGROW HEALTH) Tj ET\n";
            $this->currentY -= 16;

            $stream .= "BT /F2 12 Tf 0.882 0.114 0.282 rg " . $this->marginLeft . " " . ($this->currentY) . " Td (LAPORAN RESMI AUDIT & LOG AKTIVITAS ADMINISTRATOR) Tj ET\n";
            $this->currentY -= 14;

            $metaText = "Dicetak: " . Carbon::now()->translatedFormat('d F Y, H:i') . " WIB | Oleh: " . $this->sanitizeText($actorName) . " (Super Admin) | Status Dokumen: Valid & Terverifikasi";
            $stream .= "BT /F1 8.5 Tf 0.4 0.4 0.4 rg " . $this->marginLeft . " " . ($this->currentY) . " Td (" . $metaText . ") Tj ET\n";
            $this->currentY -= 10;

            // Horizontal Line
            $stream .= sprintf("0.8 0.8 0.8 RG 0.5 w %.2f %.2f m %.2f %.2f l S\n", $this->marginLeft, $this->currentY, $this->pageWidth - $this->marginRight, $this->currentY);
            $this->currentY -= 14;
        } else {
            // Subsequent Page Mini Header
            $stream .= sprintf("0.882 0.114 0.282 rg 0 %.2f %.2f 3 re f\n", $this->pageHeight - 3, $this->pageWidth);
            $stream .= "BT /F2 9 Tf 0.3 0.3 0.3 rg " . $this->marginLeft . " " . ($this->currentY) . " Td (NUTRIGROW - LAPORAN AUDIT LOG (Lanjutan)) Tj ET\n";
            $this->currentY -= 12;
        }

        // Footer on every page
        $footerY = 22.0;
        $stream .= sprintf("0.85 0.85 0.85 RG 0.5 w %.2f %.2f m %.2f %.2f l S\n", $this->marginLeft, $footerY + 8, $this->pageWidth - $this->marginRight, $footerY + 8);
        $footerLeft = "NutriGrow Health Security & Audit Trail System - Dokumen Rahasia & Terbatas";
        $footerRight = "Halaman " . $this->page;
        $stream .= "BT /F1 8 Tf 0.5 0.5 0.5 rg " . $this->marginLeft . " " . $footerY . " Td (" . $footerLeft . ") Tj ET\n";
        $stream .= "BT /F1 8 Tf 0.5 0.5 0.5 rg " . ($this->pageWidth - $this->marginRight - 55) . " " . $footerY . " Td (" . $footerRight . ") Tj ET\n";

        $this->pages[$this->page] .= $stream;
    }

    private function drawTableHeader(): void
    {
        $tableWidth = $this->pageWidth - $this->marginLeft - $this->marginRight;
        $headerHeight = 18.0;

        $stream = "";
        // Header background (slate-100: #f1f5f9 => 0.945, 0.961, 0.976)
        $stream .= sprintf("0.945 0.961 0.976 rg %.2f %.2f %.2f %.2f re f\n", $this->marginLeft, $this->currentY - $headerHeight, $tableWidth, $headerHeight);

        // Header Border
        $stream .= sprintf("0.75 0.75 0.75 RG 0.7 w %.2f %.2f %.2f %.2f re S\n", $this->marginLeft, $this->currentY - $headerHeight, $tableWidth, $headerHeight);

        // Column Titles
        $cols = [
            ['title' => 'NO', 'x' => $this->marginLeft + 5],
            ['title' => 'WAKTU / TANGGAL', 'x' => $this->marginLeft + 30],
            ['title' => 'PELAKU AUDIT', 'x' => $this->marginLeft + 125],
            ['title' => 'JENIS AKSI', 'x' => $this->marginLeft + 250],
            ['title' => 'AKUN TARGET', 'x' => $this->marginLeft + 355],
            ['title' => 'DESKRIPSI AKTIVITAS', 'x' => $this->marginLeft + 480],
            ['title' => 'IP ADDRESS', 'x' => $this->marginLeft + 705],
        ];

        $stream .= "BT /F2 8 Tf 0.2 0.2 0.2 rg\n";
        foreach ($cols as $col) {
            $stream .= sprintf("%.2f %.2f Td (%s) Tj\n", $col['x'], $this->currentY - 12, $col['title']);
            // Reset text matrix for next column
            $stream .= sprintf("1 0 0 1 0 0 Tm\n");
        }
        $stream .= "ET\n";

        $this->currentY -= $headerHeight;
        $this->pages[$this->page] .= $stream;
    }

    private function drawTableRow(AdminActivityLog $log, int $num, float $y): void
    {
        $tableWidth = $this->pageWidth - $this->marginLeft - $this->marginRight;
        $rowHeight = 22.0;

        $stream = "";

        // Zebra striping
        if ($num % 2 === 0) {
            $stream .= sprintf("0.985 0.985 0.985 rg %.2f %.2f %.2f %.2f re f\n", $this->marginLeft, $y - $rowHeight, $tableWidth, $rowHeight);
        }

        // Bottom border
        $stream .= sprintf("0.88 0.88 0.88 RG 0.4 w %.2f %.2f m %.2f %.2f l S\n", $this->marginLeft, $y - $rowHeight, $this->pageWidth - $this->marginRight, $y - $rowHeight);

        // Values
        $waktu = $log->created_at->format('d/m/Y H:i');
        $pelaku = $this->sanitizeText($log->actor_name);
        $pelaku = strlen($pelaku) > 22 ? substr($pelaku, 0, 19) . '...' : $pelaku;

        $aksi = $log->action;
        $target = $this->sanitizeText($log->target_name ?? '-');
        $target = strlen($target) > 20 ? substr($target, 0, 17) . '...' : $target;

        $desc = $this->sanitizeText($log->description);
        $desc = strlen($desc) > 52 ? substr($desc, 0, 49) . '...' : $desc;

        $ip = $log->ip_address ?? '127.0.0.1';

        // Render cells
        $stream .= "BT /F1 7.5 Tf 0.15 0.15 0.15 rg\n";

        // No
        $stream .= sprintf("%.2f %.2f Td (%s) Tj 1 0 0 1 0 0 Tm\n", $this->marginLeft + 6, $y - 14, (string)$num);
        // Waktu
        $stream .= sprintf("%.2f %.2f Td (%s) Tj 1 0 0 1 0 0 Tm\n", $this->marginLeft + 30, $y - 14, $waktu);
        // Pelaku
        $stream .= sprintf("%.2f %.2f Td (%s) Tj 1 0 0 1 0 0 Tm\n", $this->marginLeft + 125, $y - 14, $pelaku);
        // Aksi
        $stream .= sprintf("BT /F2 7.5 Tf 0.882 0.114 0.282 rg %.2f %.2f Td (%s) Tj ET 1 0 0 1 0 0 Tm\n", $this->marginLeft + 250, $y - 14, $aksi);
        // Target
        $stream .= sprintf("BT /F1 7.5 Tf 0.15 0.15 0.15 rg %.2f %.2f Td (%s) Tj ET 1 0 0 1 0 0 Tm\n", $this->marginLeft + 355, $y - 14, $target);
        // Desc
        $stream .= sprintf("BT /F1 7 Tf 0.25 0.25 0.25 rg %.2f %.2f Td (%s) Tj ET 1 0 0 1 0 0 Tm\n", $this->marginLeft + 480, $y - 14, $desc);
        // IP
        $stream .= sprintf("BT /F1 7.5 Tf 0.4 0.4 0.4 rg %.2f %.2f Td (%s) Tj ET 1 0 0 1 0 0 Tm\n", $this->marginLeft + 705, $y - 14, $ip);

        $stream .= "ET\n";

        $this->pages[$this->page] .= $stream;
    }

    private function drawSignatureSection(string $actorName, float $y): void
    {
        $stream = "";
        $signX = $this->pageWidth - $this->marginRight - 180;

        $stream .= "BT /F1 8 Tf 0.3 0.3 0.3 rg " . $signX . " " . $y . " Td (Jakarta, " . Carbon::now()->translatedFormat('d F Y') . ") Tj ET\n";
        $stream .= "BT /F2 8.5 Tf 0.2 0.2 0.2 rg " . $signX . " " . ($y - 12) . " Td (Super Administrator Penanggung Jawab,) Tj ET\n";

        // Space for signature
        $stream .= sprintf("0.7 0.7 0.7 RG 0.5 w %.2f %.2f m %.2f %.2f l S\n", $signX, $y - 50, $signX + 160, $y - 50);

        $stream .= "BT /F2 8.5 Tf 0.1 0.1 0.1 rg " . $signX . " " . ($y - 62) . " Td (" . $this->sanitizeText($actorName) . ") Tj ET\n";
        $stream .= "BT /F1 7.5 Tf 0.4 0.4 0.4 rg " . $signX . " " . ($y - 72) . " Td (NIP/ID: NGW-ADM-CENTRAL-01) Tj ET\n";

        $this->pages[$this->page] .= $stream;
    }

    private function sanitizeText(string $text): string
    {
        // Strip non-ascii characters or map them to clean representation for WinAnsiEncoding
        $text = str_replace(['→', '—', '–', "\xE2\x80\x9C", "\xE2\x80\x9D", "\xE2\x80\x98", "\xE2\x80\x99"], ['->', '-', '-', '"', '"', "'", "'"], $text);
        $clean = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $text);
        if ($clean === false) {
            $clean = preg_replace('/[^\x20-\x7E]/', '', $text);
        }
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $clean);
    }

    private function buildPdf(): string
    {
        $this->buffer = "%PDF-1.4\n";

        // 1: Catalog
        $this->newObj(1);
        $this->buffer .= "<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";

        // 2: Pages root
        $this->newObj(2);
        $kids = [];
        for ($i = 1; $i <= $this->page; $i++) {
            $kids[] = (2 + $i) . " 0 R";
        }
        $this->buffer .= "<< /Type /Pages /Kids [" . implode(' ', $kids) . "] /Count " . $this->page . " >>\nendobj\n";

        $contentStartObj = 2 + $this->page + 1;
        $fontObj1 = $contentStartObj + $this->page;
        $fontObj2 = $fontObj1 + 1;

        // Page objects
        for ($i = 1; $i <= $this->page; $i++) {
            $pageObjId = 2 + $i;
            $contentObjId = $contentStartObj + ($i - 1);
            $this->newObj($pageObjId);
            $this->buffer .= sprintf(
                "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 %.2f %.2f] /Resources << /Font << /F1 %d 0 R /F2 %d 0 R >> >> /Contents %d 0 R >>\nendobj\n",
                $this->pageWidth,
                $this->pageHeight,
                $fontObj1,
                $fontObj2,
                $contentObjId
            );
        }

        // Content stream objects
        for ($i = 1; $i <= $this->page; $i++) {
            $contentObjId = $contentStartObj + ($i - 1);
            $stream = $this->pages[$i];
            $len = strlen($stream);
            $this->newObj($contentObjId);
            $this->buffer .= "<< /Length " . $len . " >>\nstream\n" . $stream . "endstream\nendobj\n";
        }

        // Font 1: Helvetica (Regular)
        $this->newObj($fontObj1);
        $this->buffer .= "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>\nendobj\n";

        // Font 2: Helvetica-Bold
        $this->newObj($fontObj2);
        $this->buffer .= "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>\nendobj\n";

        // Xref
        $xrefOffset = strlen($this->buffer);
        $this->buffer .= "xref\n";
        $this->buffer .= "0 " . ($this->n + 1) . "\n";
        $this->buffer .= "0000000000 65535 f \n";
        for ($i = 1; $i <= $this->n; $i++) {
            $this->buffer .= sprintf("%010d 00000 n \n", $this->offsets[$i]);
        }

        // Trailer
        $this->buffer .= "trailer\n";
        $this->buffer .= "<< /Size " . ($this->n + 1) . " /Root 1 0 R >>\n";
        $this->buffer .= "startxref\n";
        $this->buffer .= $xrefOffset . "\n";
        $this->buffer .= "%%EOF\n";

        return $this->buffer;
    }

    private function newObj(int $id): void
    {
        $this->n = $id;
        $this->offsets[$id] = strlen($this->buffer);
        $this->buffer .= $id . " 0 obj\n";
    }
}
