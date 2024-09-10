<?php

namespace App\Http\Controllers;

use App\Models\AlertModel;
use App\Models\EspecialidadModel;
use App\Models\EstadoModel;
use Illuminate\Http\Request;

class GestAlertsController extends Controller
{
    //

    public function index()
    {
        $alerts = AlertModel::all();
        $estados = EstadoModel::all();
        $especialidades = EspecialidadModel::all();

        return view('gest_alerts', [
            'alerts' => $alerts,
            'especialidades' => $especialidades,
            'estados' => $estados
        ]);
    }
}
