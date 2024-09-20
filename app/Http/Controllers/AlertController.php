<?php

namespace App\Http\Controllers;

use App\Models\PersonaAlephooModel;
use App\Models\PersonaLocalModel;
use App\Models\AlertModel;
use App\Models\DatoPersonaModel;
use App\Models\EspecialidadModel;
use App\Models\EstadoAlertaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlertController extends Controller
{
    //

    public function index()
    {
        $especialidades = EspecialidadModel::all();
        $especialidadPrincipal = Auth::user()->especialidad_id;
        return view('create_alert', ['especialidades' => $especialidades, 'especialidadPrincipal' => $especialidadPrincipal]);
    }

    public function store(Request $request)
    {

        $is_in_alephoo = $request->input('is_in_alephoo');

        if ($is_in_alephoo) {
            $persona = PersonaAlephooModel::find($request->input('addId'));
        } else {
            $persona = PersonaLocalModel::getPersonalDataByDNIObject($request->input('addDNI'));

            if ($persona) {
                $persona->nombres = $request->input('addNombre');
                $persona->apellidos = $request->input('addApellido');
                $persona->fecha_nacimiento = $request->input('addFechaNac');
                $persona->celular = $request->input('addCelular');
                $persona->email = $request->input('addEmail');
                $persona->documento = $request->input('addDNI');
                $persona->update();
            } else {
                $persona = new PersonaLocalModel();
                $persona->nombres = $request->input('addNombre');
                $persona->apellidos = $request->input('addApellido');
                $persona->fecha_nacimiento = $request->input('addFechaNac');
                $persona->celular = $request->input('addCelular');
                $persona->email = $request->input('addEmail');
                $persona->documento = $request->input('addDNI');
                $persona->save();
            }
        }

        $alert = new AlertModel();
        $alert->persona_id = $persona->id;
        $alert->especialidad_id = $request->input('addEspecialidad');
        $alert->detalle = $request->input('addDetalle');
        switch ($request->input('fecha_alert')) {
            case '6meses':
                $alert->fecha_objetivo = Carbon::now()->addMonths(6);
                $alert->tipo_frecuencia = "meses";
                $alert->frecuencia = intval(6);
                break;

            case '1anio':
                $alert->fecha_objetivo = Carbon::now()->addYear();
                $alert->tipo_frecuencia = "anios";
                $alert->frecuencia = intval(1);
                break;

            case '2anios':
                $alert->fecha_objetivo = Carbon::now()->addYears(2);
                $alert->tipo_frecuencia = "anios";
                $alert->frecuencia = intval(2);
                break;

            case '5anios':
                $alert->fecha_objetivo = Carbon::now()->addYears(5);
                $alert->tipo_frecuencia = "anios";
                $alert->frecuencia = intval(5);
                break;

            case 'personalizado':
                // Asumimos que 'numPersonalizado' y 'unidadPersonalizado' están correctamente establecidos
                $numero = intval($request->input('numPersonalizado'));
                $unidad = $request->input('unidadPersonalizado');

                if ($unidad === 'meses') {
                    $alert->fecha_objetivo = Carbon::now()->addMonths($numero);
                } elseif ($unidad === 'anios') {
                    $alert->fecha_objetivo = Carbon::now()->addYears($numero);
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
        $alert->created_by = Auth::user()->name;
        $alert->save();

        $estado = new EstadoAlertaModel();
        $estado->alerta_id = $alert->id;
        $estado->estado_id = 1;
        $estado->save();

        return redirect()->route('alerts')->with('success', 'Alerta creada correctamente.');
    }

    public function store2(Request $request)
    {
        // Obtener los datos de la solicitud
        $personalInfo = $request->input('personalInfo');
        $is_in_alephoo = $personalInfo['is_in_alephoo'];
        // Verificar que los datos existan
        if ($personalInfo && $is_in_alephoo) {

            // Verificar y guardar el email si está presente y no existe en la base de datos
            if (isset($personalInfo['addEmail']) && !empty($personalInfo['addEmail'])) {
                if (!DatoPersonaModel::where('tipo_dato', 'email')->where('persona_id', $personalInfo['addId'])->exists()) {
                    $dato = new DatoPersonaModel();
                    $dato->dato = $personalInfo['addEmail'];
                    $dato->tipo_dato = 'email';
                    $dato->persona_id = $personalInfo['addId'];
                    $dato->save();
                } else {
                    $dato = DatoPersonaModel::where('tipo_dato', 'email')->where('persona_id', $personalInfo['addId'])->first();
                    $dato->dato = $personalInfo['addEmail'];
                    $dato->tipo_dato = 'email';
                    $dato->persona_id = $personalInfo['addId'];
                    $dato->update();
                }
            }

            // Verificar y guardar el celular si está presente y no existe en la base de datos
            if (isset($personalInfo['addCelular']) && !empty($personalInfo['addCelular'])) {
                if (!DatoPersonaModel::where('tipo_dato', 'celular')->where('persona_id', $personalInfo['addId'])->exists()) {
                    $dato = new DatoPersonaModel();
                    $dato->dato = $personalInfo['addCelular'];
                    $dato->tipo_dato = 'celular';
                    $dato->persona_id = $personalInfo['addId'];
                    $dato->save();
                } else {
                    $dato = DatoPersonaModel::where('tipo_dato', 'celular')->where('persona_id', $personalInfo['addId'])->first();
                    $dato->dato = $personalInfo['addCelular'];
                    $dato->tipo_dato = 'celular';
                    $dato->persona_id = $personalInfo['addId'];
                    $dato->update();
                }
            }

            // Verificar y guardar el email si está presente y no existe en la base de datos
            if (isset($personalInfo['editEmail']) && !empty($personalInfo['editEmail'])) {
                if (!DatoPersonaModel::where('tipo_dato', 'email')->where('persona_id', $personalInfo['editId'])->exists()) {
                    $dato = new DatoPersonaModel();
                    $dato->dato = $personalInfo['editEmail'];
                    $dato->tipo_dato = 'email';
                    $dato->persona_id = $personalInfo['editId'];
                    $dato->save();
                } else {
                    $dato = DatoPersonaModel::where('tipo_dato', 'email')->where('persona_id', $personalInfo['editId'])->first();
                    $dato->dato = $personalInfo['editEmail'];
                    $dato->tipo_dato = 'email';
                    $dato->persona_id = $personalInfo['editId'];
                    $dato->update();
                }
            }

            // Verificar y guardar el celular si está presente y no existe en la base de datos
            if (isset($personalInfo['editCelular']) && !empty($personalInfo['editCelular'])) {
                if (!DatoPersonaModel::where('tipo_dato', 'celular')->where('persona_id', $personalInfo['editId'])->exists()) {
                    $dato = new DatoPersonaModel();
                    $dato->dato = $personalInfo['editCelular'];
                    $dato->tipo_dato = 'celular';
                    $dato->persona_id = $personalInfo['editId'];
                    $dato->save();
                } else {
                    $dato = DatoPersonaModel::where('tipo_dato', 'celular')->where('persona_id', $personalInfo['editId'])->first();
                    $dato->dato = $personalInfo['editCelular'];
                    $dato->tipo_dato = 'celular';
                    $dato->persona_id = $personalInfo['editId'];
                    $dato->update();
                }
            }
        }
    }

    public function edit_index($id)
    {
        $alert = AlertModel::find($id);
        if ($alert->is_in_alephoo) {
            $personaAlephoo = new PersonaAlephooModel();
            $persona = $personaAlephoo->getPersonalDataByIdArray($alert->persona_id);
        } else {
            $persona = PersonaLocalModel::find($alert->persona_id);
        }

        $especialidades = EspecialidadModel::all();
        return view('edit_alert', ['alert' => $alert, 'especialidades' => $especialidades, 'persona' => $persona]);
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

        $alert->save();

        return redirect()->route('alerts')->with('success', 'Alerta editada correctamente.');
    }

    public function gest_index($id)
    {
        $alert = AlertModel::find($id);
        if ($alert->is_in_alephoo) {
            $personaAlephoo = new PersonaAlephooModel();
            $persona = $personaAlephoo->getPersonalDataByIdArray($alert->persona_id);
        } else {
            $persona = PersonaLocalModel::find($alert->persona_id);
        }

        $especialidades = EspecialidadModel::all();
        return view('gestion_alert', ['alert' => $alert, 'especialidades' => $especialidades, 'persona' => $persona]);
    }

    // TuControlador.php
    public function getPersonalDataByDNI(Request $request)
    {
        $documento = $request->input('documento');
        $persona = new PersonaAlephooModel();

        $data = $persona->getPersonalDataByDNI($documento);

        if ($data) {
            return response()->json($data);
        }

        return response()->json(['error' => 'No se encontró a la persona']);
    }

    public function getPersonalDataLocalByDNI(Request $request)
    {
        $documento = $request->input('documento');
        $persona = new PersonaLocalModel();

        $data = $persona->getPersonalDataByDNI($documento);

        if ($data) {
            return response()->json($data);
        }

        return response()->json(['error' => 'No se encontró a la persona']);
    }

    public function getPersonalDataLocalEmptyInputsByDNI(Request $request)
    {

        $id = $request->input('id');
        $dato = new DatoPersonaModel();

        $data = $dato->getPersonalDataById($id);

        if ($data) {
            return response()->json($data);
        }

        return response()->json(['error' => 'No se encontró a la persona']);
    }

    public function agregarEstado(Request $request)
    {
        log::info("Agregar");
        $alertId = $request->input('alertId');
        $estadoId = $request->input('estadoId');

        // Lógica para agregar el estado a la base de datos
        EstadoAlertaModel::create([
            'alerta_id' => $alertId,
            'estado_id' => $estadoId
        ]);

        return response()->json(['success' => true]);
    }

    public function eliminarEstado(Request $request)
    {
        log::info("Eliminar");
        $alertId = $request->input('alertId');
        $estadoId = $request->input('estadoId');

        // Lógica para eliminar el estado de la base de datos
        EstadoAlertaModel::where('alerta_id', $alertId)
                         ->where('estado_id', $estadoId)
                         ->delete();

        return response()->json(['success' => true]);
    }
}
