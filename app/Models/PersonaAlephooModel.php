<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class PersonaAlephooModel extends Model
{
    protected $table = 'persona';
    protected $connection = 'db2'; // Especifica la conexión a 'db2'

    public static function getPersonalDataByDNI($dni)
    {
        return response()->json(DB::connection('db2') // Asegúrate de usar la conexión 'db2'
            ->table('persona as p')
            ->select(
                'p.id',
                'p.documento',
                'p.apellidos',
                'p.nombres',
                'p.fecha_nacimiento',
                DB::raw("CONCAT('+',COALESCE(CAST(p.contacto_celular_prefijo AS CHAR), ''), 
                                 COALESCE(CAST(p.contacto_celular_codigo AS CHAR), ''), 
                                 COALESCE(CAST(p.contacto_celular_numero AS CHAR), '')) as celular"),
                'p.contacto_email_direccion as email'
            )
            ->where('p.documento', $dni)
            ->first());
    }

    public static function getPersonalDataById($id)
    {
        return response()->json(DB::connection('db2') // Asegúrate de usar la conexión 'db2'
            ->table('persona as p')
            ->select(
                'p.id',
                'p.documento',
                'p.apellidos',
                'p.nombres',
                'p.fecha_nacimiento',
                DB::raw("CONCAT('+',COALESCE(CAST(p.contacto_celular_prefijo AS CHAR), ''), 
                                 COALESCE(CAST(p.contacto_celular_codigo AS CHAR), ''), 
                                 COALESCE(CAST(p.contacto_celular_numero AS CHAR), '')) as celular"),
                'p.contacto_email_direccion as email'
            )
            ->where('p.id', $id)
            ->first());
    }
    public static function getPersonalDataByIdArray($id)
    {
        return DB::connection('db2') // Asegúrate de usar la conexión 'db2'
            ->table('persona as p')
            ->select(
                'p.id',
                'p.documento',
                'p.apellidos',
                'p.nombres',
                'p.fecha_nacimiento',
                DB::raw("CONCAT('+',COALESCE(CAST(p.contacto_celular_prefijo AS CHAR), ''), 
                                 COALESCE(CAST(p.contacto_celular_codigo AS CHAR), ''), 
                                 COALESCE(CAST(p.contacto_celular_numero AS CHAR), '')) as celular"),
                'p.contacto_email_direccion as email'
            )
            ->where('p.id', $id)
            ->first();
    }
}
