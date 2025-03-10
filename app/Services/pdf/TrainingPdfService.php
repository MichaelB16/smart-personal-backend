<?php

namespace App\Services\Pdf;

use App\Contracts\PdfInterface;
use Barryvdh\DomPDF\Facade\Pdf;

class TrainingPdfService implements PdfInterface
{
    public function generatePdf(array $data)
    {
        return Pdf::loadView('pdf.training', $data)->output();
    }
}
