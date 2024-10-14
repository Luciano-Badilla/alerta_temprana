<?php

namespace App\Http\Controllers;

use App\Models\PersonaAlephooModel;
use App\Models\PersonaLocalModel;
use App\Models\AlertModel;
use App\Models\DatoPersonaModel;
use App\Models\EspecialidadModel;
use App\Models\EstadoAlertaModel;
use App\Models\ExamenAlertModel;
use App\Models\ExamenModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExamenController extends Controller
{
    public function index()
    {
        $especialidades = EspecialidadModel::all();
        $especialidadPrincipal = Auth::user()->especialidad_id;
        $tiposExamen = ExamenModel::all();
        return view('especialidades', [
            'especialidades' => $especialidades,
            'especialidadPrincipal' => $especialidadPrincipal,
            'tiposExamen' => $tiposExamen
        ]);
    }

    public function store(Request $request)
    {
        $examen = new ExamenModel();
        $examen->especialidad_id = $request->input('especialidad_id');
        $examen->nombre = $request->input('addNombre');
        $examen->save();

        return redirect()->route('especialidad.create')->with('success', 'Examen agregado correctamente.');
    }

    public function alter_borrado_logico(Request $request)
    {
        $id = $request->input('examen_id');
        $examen = ExamenModel::find($id);
        if ($examen->borrado_logico == 1) {
            $examen->borrado_logico = 0;
            $examen->save();
            return redirect()->route('especialidad.create')->with('warning', $examen->nombre.' activado.');
        } else {
            $examen->borrado_logico = 1;
            $examen->save();
            return redirect()->route('especialidad.create')->with('warning', $examen->nombre.' desactivado.');
        }


    }
}
