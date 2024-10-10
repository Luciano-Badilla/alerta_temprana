<?php

namespace App\Http\Controllers;

use App\Models\AlertModel;
use App\Models\EspecialidadModel;
use App\Models\EstadoModel;
use App\Models\TiposExamenModel;
use App\Models\TiposExamenAlertModel;
use Illuminate\Http\Request;

class GestAlertsController extends Controller
{
    //

    public function index()
    {
        $alerts = AlertModel::all();
        $estados = EstadoModel::all();
        $especialidades = EspecialidadModel::all();

        $tiposExamenSelected = TiposExamenAlertModel::all();

        return view('alerts', [
            'alerts' => $alerts,
            'especialidades' => $especialidades,
            'estados' => $estados,
            'tiposExamenSelected' => $tiposExamenSelected
        ]);
    }
}
