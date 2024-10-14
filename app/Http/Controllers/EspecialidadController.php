<?php

namespace App\Http\Controllers;

use App\Models\EstadoModel;
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

class EspecialidadController extends Controller
{
    //

    public function index()
    {
        $especialidades = EspecialidadModel::all();
        $especialidadPrincipal = Auth::user()->especialidad_id;
        $tiposExamen = ExamenModel::orderBy('borrado_logico', 'asc')->get();
        return view('especialidades', [
            'especialidades' => $especialidades,
            'especialidadPrincipal' => $especialidadPrincipal,
            'tiposExamen' => $tiposExamen
        ]);
    }

    public function store(Request $request)
    {
        $estado = new EspecialidadModel();
        $estado->nombre = $request->input('addNombre');
        $estado->save();

        return redirect()->route('especialidad.create')->with('success', 'Especialidad creada correctamente.');
    }

    public function edit(Request $request)
    {
        $alert = AlertModel::find($request->input("editAlertId"));

        $is_in_alephoo = $request->input('is_in_alephoo');

        if ($is_in_alephoo) {
            $persona = PersonaAlephooModel::find($request->input('editId'));
        } else {
            $persona = PersonaLocalModel::getPersonalDataByDNIObject($request->input('editDNI'));

            if ($persona) {
                $persona->nombres = $request->input('editNombre');
                $persona->apellidos = $request->input('editApellido');
                $persona->fecha_nacimiento = $request->input('editFechaNac');
                $persona->celular = $request->input('editCelular');
                $persona->email = $request->input('editEmail');
                $persona->documento = $request->input('editDNI');
                $persona->update();
            } else {
                $persona = new PersonaLocalModel();
                $persona->nombres = $request->input('editNombre');
                $persona->apellidos = $request->input('editApellido');
                $persona->fecha_nacimiento = $request->input('editFechaNac');
                $persona->celular = $request->input('editCelular');
                $persona->email = $request->input('editEmail');
                $persona->documento = $request->input('editDNI');
                $persona->save();
            }
        }

        $alert->persona_id = $persona->id;
        $alert->especialidad_id = $request->input('editEspecialidad');
        $alert->detalle = $request->input('editDetalle');
        switch ($request->input('fecha_alert')) {
            case '6meses':
                $alert->fecha_objetivo = Carbon::parse($alert->created_at)->addMonths(6);
                $alert->tipo_frecuencia = "meses";
                $alert->frecuencia = intval(6);
                break;

            case '1anio':
                $alert->fecha_objetivo = Carbon::parse($alert->created_at)->addYear();
                $alert->tipo_frecuencia = "anios";
                $alert->frecuencia = intval(1);
                break;

            case '2anios':
                $alert->fecha_objetivo = Carbon::parse($alert->created_at)->addYears(2);
                $alert->tipo_frecuencia = "anios";
                $alert->frecuencia = intval(2);
                break;

            case '5anios':
                $alert->fecha_objetivo = Carbon::parse($alert->created_at)->addYears(5);
                $alert->tipo_frecuencia = "anios";
                $alert->frecuencia = intval(5);
                break;

            case 'personalizado':
                // Asumimos que 'numPersonalizado' y 'unidadPersonalizado' están correctamente establecidos
                $numero = intval($request->input('numPersonalizado'));
                $unidad = $request->input('unidadPersonalizado');

                if ($unidad === 'meses') {
                    $alert->fecha_objetivo = Carbon::parse($alert->created_at)->addMonths($numero);
                } elseif ($unidad === 'anios') {
                    $alert->fecha_objetivo = Carbon::parse($alert->created_at)->addYears($numero);
                }
                $alert->frecuencia = intval($request->input('numPersonalizado'));
                $alert->tipo_frecuencia = $unidad;
                break;

            default:
                // Manejar otros casos si es necesario
                break;
        }
        $alert->tipo_id = $request->input('tipo_alerta');
        $alert->is_in_alephoo = $is_in_alephoo;
        $alert->updated_by = Auth::user()->name;

        $oldRelation = ExamenAlertModel::where('alert_id', $request->input("editAlertId"))->get(); // Obtén la colección

        foreach ($oldRelation as $item) {
            $item->delete(); // Elimina cada modelo individualmente
        }

        foreach ($request->input('editTipoExamen') as $tipoExamen) {
            $relacion = new ExamenAlertModel();
            $relacion->tipo_examen_id = $tipoExamen;
            $relacion->alert_id = $alert->id;
            $relacion->save();
        }

        $alert->save();

        return redirect()->route('alerts')->with('success', 'Alerta editada correctamente.');
    }
}
