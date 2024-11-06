<?php

namespace App\Http\Controllers;

use App\Models\AlertModel;
use App\Models\EspecialidadModel;
use App\Models\EstadoAlertaModel;
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
        if ($alert->is_in_alephoo == 1) {
            $personaAlephoo = new PersonaAlephooModel();
            $paciente = $personaAlephoo->getPersonalDataByIdArray($alert->persona_id);
        } else {
            $paciente = PersonaLocalModel::find($alert->persona_id);
        }

        // Obtener los otros datos necesarios
        $estados = EstadoModel::all();
        $especialidades = EspecialidadModel::all();
        $examenes = ExamenAlertModel::where('alert_id', $id)->get();
        Log::info($examenes);

        // Agrupar todos los datos en un array
        $data = [
            'alert' => $alert,
            'estados' => $estados,
            'especialidades' => $especialidades,
            'examenes' => $examenes,
            'paciente' => $paciente
        ];

        $estado = EstadoAlertaModel::where('alerta_id', $id)->where('estado_id', 11)->first();
        if (!$estado) {
            $nuevoEstado = new EstadoAlertaModel();
            $nuevoEstado->estado_id = 11;
            $nuevoEstado->alerta_id = $id;
            $nuevoEstado->save();

            $alert->pedido_medico_created_at = \Carbon\Carbon::now()->format('Y-m-d');
            $alert->update();
        }

        // Configurar el tamaño de papel personalizado y cargar la vista
        $pdf = Pdf::loadView('pdfs/pedido_medico', $data)->setPaper([0, 0, 360, 576], 'portrait'); // 5x8 pulgadas en puntos

        // Descargar el PDF
        return $pdf->stream('Pedido medico - ' . $data['paciente']->nombres . ' ' . $data['paciente']->apellidos . '.pdf');
    }
}
