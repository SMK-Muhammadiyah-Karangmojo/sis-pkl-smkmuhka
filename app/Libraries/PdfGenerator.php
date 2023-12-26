<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

namespace App\Libraries;

use Config\IApplicationConstantConfig;
use Dompdf\Dompdf;
use Mpdf\Mpdf;

/**
 * @property Mpdf $mpdf
 * @property IApplicationConstantConfig $IApplicationConstant
 * @property Dompdf $dompdf
 */
class PdfGenerator
{

    public function __construct()
    {
        $this->mpdf = new Mpdf();
        $this->IApplicationConstant = new IApplicationConstantConfig();
        $this->dompdf = new Dompdf();
    }

    public function generatePdf($html, $filename = 'output.pdf')
    {
        $this->mpdf->showImageErrors = true;
        $this->mpdf->WriteHTML(htmlspecialchars($html));
        header('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $this->mpdf->Output($filename, 'I');
    }

    public function generatePDFDomp($html, $filename = 'document')
    {
        $this->dompdf->loadHtml($html);

        // (Opsional) Konfigurasi tambahan, seperti ukuran kertas, margin, dll.
        $this->dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $this->dompdf->render();

        // Output PDF ke file atau browser
        $this->dompdf->stream($filename . '.pdf', [
            'Attachment' => 0 // Ubah menjadi 1 jika ingin mengunduh secara otomatis
        ]);
    }
}