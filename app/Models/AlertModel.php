<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class AlertModel extends Model
{
    protected $table = 'alertas';

    public $timestamps = true;

    protected $fillable = [
        'persona_id',
        'especialidad_id',
        'detalle',
        'fecha_objetivo',
        'created_at',
        'created_by',
        'is_in_alephoo',
        'updated_at',
        'tipo_id',
        'frecuencia',
        'tipo_frecuencia',
        'updated_by'
    ];

    public function tiposExamen()
    {
        return $this->hasMany(ExamenAlertModel::class, 'alert_id');
    }
}
