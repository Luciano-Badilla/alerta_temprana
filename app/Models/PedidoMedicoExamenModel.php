<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class PedidoMedicoExamenModel extends Model
{
    protected $table = 'examen_pedido_medico';  

    public $timestamps = false;

    protected $fillable = [
        'examen_id',
        'pedido_medico_id'
    ];
}
