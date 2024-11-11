<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class PedidoMedicoModel extends Model
{
    protected $table = 'pedido_medico';

    public $timestamps = true;

    protected $fillable = [
        'alerta_id',
        'persona_id',
        'created_at',
        'nombre'
    ];
}
