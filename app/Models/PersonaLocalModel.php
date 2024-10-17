<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class PersonaLocalModel extends Model
{
    protected $table = 'persona';
    protected $connection = 'mysql'; // Especifica la conexión a 'db'

    protected $fillable = [
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'celular',
        'email',
        'dni',
    ];

    public static function getPersonalDataByDNI($dni)
    {
        return response()->json(DB::connection('mysql') // Asegúrate de usar la conexión 'mysql'
            ->table('persona as p')
            ->select(
                'p.id',
                'p.documento',
                'p.apellidos',
                'p.nombres',
                'p.fecha_nacimiento',
                'p.celular as celular',
                'p.email as email',
                'p.obra_social as obra_social',
            )
            ->where('p.documento', $dni)
            ->first());
    }

    public static function getPersonalDataByDNIObject($dni)
    {
        return self::where('documento', $dni)->first();
    }
}
