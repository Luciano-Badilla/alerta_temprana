<?php

namespace App\Http\Controllers;

use App\Models\PersonaAlephooModel;
use App\Models\PersonaLocalModel;
use App\Models\AlertModel;
use App\Models\DatoPersonaModel;
use App\Models\EspecialidadModel;
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
        return view('create_alert',['especialidades'=>$especialidades]);
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
                break;

            case '1anio':
                $alert->fecha_objetivo = Carbon::now()->addYear();
                break;

            case '2anios':
                $alert->fecha_objetivo = Carbon::now()->addYears(2);
                break;

            case '5anios':
                $alert->fecha_objetivo = Carbon::now()->addYears(5);
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
                break;

            default:
                // Manejar otros casos si es necesario
                break;
        }
        $alert->frecuencia = intval($request->input('numPersonalizado'));
        $alert->tipo_id = $request->input('tipo_alerta');
        $alert->estado_id = 1;
        $alert->is_in_alephoo = $is_in_alephoo;
        $alert->created_by = Auth::user()->name;

        $alert->save();

        return redirect()->route('gest.alerts')->with('success', 'Alerta creada correctamente.');
    }

    public function store2(Request $request)
    {
        // Obtener los datos de la solicitud
        $personalInfo = $request->input('personalInfo');
        // Verificar que los datos existan
        if ($personalInfo) {

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
                    $dato->save();
                }
            }
        }
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
}
