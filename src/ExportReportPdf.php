<?php

namespace PHPMaker2022\juzmatch;

/**
 * Class for export to PDF
 */
class ExportReportPdf
{
    // Export
    public function __invoke($page, $html)
    {
        header("HTTP/1.0 500 Export PDF extension disabled");
        die();
    }
}
