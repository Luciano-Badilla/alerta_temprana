<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamenAlertModel extends Model
{
    protected $table = 'tipo_examen_alerta';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'tipo_examen_id',
        'alert_id',
    ];

    // Relación con el modelo Alerta
    public function alerta()
    {
        return $this->belongsTo(AlertModel::class, 'alert_id');
    }

    // Relación con el modelo TipoExamen
    public function tipoExamen()
    {
        return $this->belongsTo(ExamenModel::class, 'tipo_examen_id');
    }
}
