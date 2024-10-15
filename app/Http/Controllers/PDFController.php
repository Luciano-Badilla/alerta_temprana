<?php

namespace App\Http\Controllers;

use App\Models\AlertModel;
use App\Models\EspecialidadModel;
use App\Models\EstadoModel;
use App\Models\ExamenModel;
use App\Models\ExamenAlertModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generate($id)
    {
        // Buscar la alerta
        $alert = AlertModel::find($id);

        // Obtener los otros datos necesarios
        $estados = EstadoModel::all();
        $especialidades = EspecialidadModel::all();
        $tiposExamenSelected = ExamenAlertModel::all();

        // Agrupar todos los datos en un array
        $data = [
            'alert' => $alert,
            'estados' => $estados,
            'especialidades' => $especialidades,
            'tiposExamenSelected' => $tiposExamenSelected
        ];

        // Pasar los datos a la vista
        $pdf = Pdf::loadView('pdfs/pedido_medico', $data);

        // Descargar el PDF
        return $pdf->stream('reporte.pdf');
    }
}
