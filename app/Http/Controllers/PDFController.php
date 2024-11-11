<?php

namespace App\Http\Controllers;

use App\Models\AlertModel;
use App\Models\EspecialidadModel;
use App\Models\EstadoAlertaModel;
use App\Models\EstadoModel;
use App\Models\ExamenModel;
use App\Models\ExamenAlertModel;
use App\Models\PedidoMedicoExamenModel;
use App\Models\PedidoMedicoModel;
use App\Models\PersonaAlephooModel;
use App\Models\PersonaLocalModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generate($id, Request $request)
    {
        Log::info($request);
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
        $nombre = $request->input('nombrePedido');
        if (!$nombre) {
            return redirect()->back()->with('error', 'Debe ingresar un nombre identificable para el pedido.');
        }
        $examenes = $request->input('examenes');
        if (!$examenes) {
            return redirect()->back()->with('error', 'Debe seleccionar al menos un examen.');
        }
        $examenes = array_map(function ($examen) {
            return trim(str_replace('-', '', $examen));
        }, $examenes);

        $examenesId = ExamenModel::whereIn('nombre', $examenes)->get();
        Log::info($examenes);


        // Agrupar todos los datos en un array
        $data = [
            'alert' => $alert,
            'estados' => $estados,
            'especialidades' => $especialidades,
            'examenesId' => $examenesId,
            'paciente' => $paciente
        ];

        $pedido_medico = PedidoMedicoModel::create([
            'alerta_id' => $id,
            'persona_id' => $paciente->id,
            'nombre' => $nombre
        ]);

        foreach ($examenesId as $examen) {
            PedidoMedicoExamenModel::create([
                'pedido_medico_id' => $pedido_medico->id,
                'examen_id' => $examen->id
            ]);
        }

        /*$estado = EstadoAlertaModel::where('alerta_id', $id)->where('estado_id', 11)->first();
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
        return $pdf->stream('Pedido medico - ' . $data['paciente']->nombres . ' ' . $data['paciente']->apellidos . '.pdf');*/

        return redirect()->back()->with('success', 'Pedido Medico generado con exito.');
    }

    public function ver($pedido_medico_id)
    {
        Log::info($pedido_medico_id);
        // Buscar la alerta
        $pedido_medico = PedidoMedicoModel::find($pedido_medico_id);
        $alert = AlertModel::find($pedido_medico->alerta_id);
        if ($alert->is_in_alephoo == 1) {
            $personaAlephoo = new PersonaAlephooModel();
            $paciente = $personaAlephoo->getPersonalDataByIdArray($alert->persona_id);
        } else {
            $paciente = PersonaLocalModel::find($alert->persona_id);
        }

        // Obtener los otros datos necesarios
        $estados = EstadoModel::all();
        $especialidades = EspecialidadModel::all();
        $nombre = PedidoMedicoModel::find($pedido_medico_id)->nombre;
        $examenesId = PedidoMedicoExamenModel::where('pedido_medico_id', $pedido_medico_id)->get();


        // Agrupar todos los datos en un array
        $data = [
            'alert' => $alert,
            'estados' => $estados,
            'especialidades' => $especialidades,
            'examenesId' => $examenesId,
            'paciente' => $paciente,
            'id' => $pedido_medico_id
        ];
        /*$estado = EstadoAlertaModel::where('alerta_id', $id)->where('estado_id', 11)->first();
        if (!$estado) {
            $nuevoEstado = new EstadoAlertaModel();
            $nuevoEstado->estado_id = 11;
            $nuevoEstado->alerta_id = $id;
            $nuevoEstado->save();

            $alert->pedido_medico_created_at = \Carbon\Carbon::now()->format('Y-m-d');
            $alert->update();
        }*/

        // Configurar el tamaño de papel personalizado y cargar la vista
        $pdf = Pdf::loadView('pdfs/pedido_medico', $data)->setPaper([0, 0, 360, 576], 'portrait'); // 5x8 pulgadas en puntos

        // Descargar el PDF
        return $pdf->stream('Pedido medico - ' . $data['paciente']->nombres . ' ' . $data['paciente']->apellidos . '.pdf');
    }
}
