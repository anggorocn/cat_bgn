<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'title' => 'Contoh PDF',
            'content' => 'Ini adalah contoh konten untuk PDF yang dihasilkan menggunakan mPDF di Laravel.'
        ];

        $html = view('cetakan/coba', $data)->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('document.pdf', 'I');
    }
}
