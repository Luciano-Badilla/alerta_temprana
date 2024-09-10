<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class DatoPersonaModel extends Model
{
    protected $table = 'dato_persona';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'tipo_dato',
        'persona_id'
    ];

    public function getPersonalDataById($id){
        return response()->json(self::where('persona_id', $id)->get());
    }
}
