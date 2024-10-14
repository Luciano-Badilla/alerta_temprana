<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class ExamenModel extends Model
{
    protected $table = 'tipo_examen';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'especialidad_id'
    ];

    public function alertas()
    {
        return $this->hasMany(ExamenAlertModel::class, 'tipo_examen_id');
    }
}
