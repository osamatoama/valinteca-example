<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use MPDF;
class PdfExportService
{

    private $data;

    private $view;

    private $filename;

    private $height;

    private $width;

    public function __construct($data, $view, $filename, $height, $width)
    {
        $this->data = $data;
        $this->view = $view;
        $this->filename = $filename;
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * Export PDF
     */
    public function export()
    {
        $pdf = MPDF::loadView($this->view, $this->data, [], [
            'format'       => [$this->width, $this->height],
            'display_mode' => 'fullpage',
            'title'        => 'Laravel mPDF',
            'mode'         => 'utf-8',
        ]);

//        return $pdf->save(Storage::path('public/attachments/' . $this->filename . '.pdf'));
        return $pdf->stream();
    }

    public function download()
    {
        $pdf = MPDF::loadView($this->view, $this->data, [], [
            'format'       => [$this->width, $this->height],
            'display_mode' => 'real',
        ]);

        return $pdf->download($this->filename . '.pdf');
    }
}
