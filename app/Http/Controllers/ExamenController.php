<?php

namespace App\Http\Controllers;

use App\Models\EspecialidadModel;
use App\Models\ExamenModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        $request->validate([
            'addNombre' => [
                'required',
                Rule::unique('tipo_examen', 'nombre')->where(function ($query) use ($request) {
                    return $query->where('especialidad_id', $request->input('especialidad_id'));
                }),
            ],
        ], [
            'addNombre.unique' => 'El examen ' . $request->input('addNombre') . ' ya existe en la especialidad seleccionada.',
        ]);


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
            return redirect()->route('especialidad.create')->with('warning', $examen->nombre . ' activado.');
        } else {
            $examen->borrado_logico = 1;
            $examen->save();
            return redirect()->route('especialidad.create')->with('warning', $examen->nombre . ' desactivado.');
        }
    }
}
