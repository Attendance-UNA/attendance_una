<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class reportController extends Controller
{
    /**
     * Receive the request to generate a report
     */
    public function generateReport() {
        $persons = DB::table('tbperson')->get();
        $pdf = Pdf::loadView('report.desingReportView', compact('persons'));
        return $pdf->download('Reporte asistencias.pdf');
    }
}