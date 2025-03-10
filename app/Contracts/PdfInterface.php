<?php

namespace App\Contracts;

interface PdfInterface
{
    public function generatePdf(array $data);
}
