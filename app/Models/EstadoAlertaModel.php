<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class EstadoAlertaModel extends Model
{
    protected $table = 'estado_alerta';

    public $timestamps = false;

    protected $fillable = [
        'alerta_id',
        'estado_id'
    ];

    public static function getEstadosById($id)
    {
        return EstadoAlertaModel::where('alerta_id', $id)->get();
    }
}
