<?php

namespace App\Http\Controllers;

use App\Models\AlertModel;
use App\Models\EspecialidadModel;
use App\Models\EstadoModel;
use App\Models\ExamenModel;
use App\Models\ExamenAlertModel;
use App\Models\PersonaAlephooModel;
use App\Models\PersonaLocalModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generate($id)
    {
        // Buscar la alerta
        $alert = AlertModel::find($id);
        if($alert->is_in_alephoo == 1){
            $personaAlephoo = New PersonaAlephooModel();
            $paciente = $personaAlephoo->getPersonalDataByIdArray($alert->persona_id);
        }else{
            $paciente = PersonaLocalModel::find($alert->persona_id);
        }

        // Obtener los otros datos necesarios
        $estados = EstadoModel::all();
        $especialidades = EspecialidadModel::all();
        $examenes = ExamenAlertModel::where('alert_id',$id)->get();
        log::info($examenes);

        // Agrupar todos los datos en un array
        $data = [
            'alert' => $alert,
            'estados' => $estados,
            'especialidades' => $especialidades,
            'examenes' => $examenes,
            'paciente' => $paciente
        ];

        // Pasar los datos a la vista
        $pdf = Pdf::loadView('pdfs/pedido_medico', $data);

        // Descargar el PDF
        return $pdf->stream('reporte.pdf');
    }
}
