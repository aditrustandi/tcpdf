<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use PDF;

class HomeController extends Controller
{

    public function index()
    {
        return '<a href="/download">Download</a> or <a href="/view">View</a>';
    }

    public function generatePDF($action)
    {
        $svg = public_path('svg-file.svg');
        $png = public_path('instagram.png');
        $file_name = time('now');

        PDF::SetTitle('TCPDF TEST');

        // FIRST PAGE
        PDF::AddPage();
        PDF::Write(100, 'SVG image position on "Bottom Right"', '', 0, 'C', true, 0, false, false, 0);
        PDF::ImageSVG($file=$svg, $x=150, $y=210, $w=48, $h=48, $link='', $align='', $palign='', $border=0, $fitonpage=false);

        // SECOND PAGE
        PDF::AddPage();
        PDF::Write(0, 'PNG image position on "Center"', '', 0, 'C', true, 0, false, false, 0);
        PDF::Image($png, $x=82, $y=100, $w=48, $h=48, '', '', '', false, 0, '', false, false, 0);

        if ($action == 'view') {
            PDF::Output($file_name.'.pdf', 'I');
        }else if($action == 'download'){
            PDF::Output(public_path('storage/pdf/'.$file_name.'.pdf'), 'F');

            return response()->download(public_path('storage/pdf/'.$file_name.'.pdf'));
        }
    }

}
