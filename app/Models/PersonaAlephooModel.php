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
            ->leftJoin('persona_usuario_portal as pup', 'pup.persona_id', '=', 'p.id')
            ->leftJoin('turno_programado as tp', 'tp.persona_id', '=', 'p.id')
            ->leftJoin('plan as pl', 'tp.plan_id', '=', 'pl.id')
            ->leftJoin('obra_social as os', 'pl.obra_social_id', '=', 'os.id')
            ->select(
                'p.id',
                'p.documento',
                'p.apellidos',
                'p.nombres',
                'p.fecha_nacimiento',
                DB::raw("CONCAT('+',COALESCE(CAST(p.contacto_celular_prefijo AS CHAR), ''), 
                             COALESCE(CAST(p.contacto_celular_codigo AS CHAR), ''), 
                             COALESCE(CAST(p.contacto_celular_numero AS CHAR), '')) as celular"),
                'p.contacto_email_direccion as email',
                'os.nombre as obra_social' // Agregamos la obra social
            )
            ->where('p.documento', $dni)
            ->first());
    }


    public static function getPersonalDataById($id)
    {
        return response()->json(DB::connection('db2') // Asegúrate de usar la conexión 'db2'
            ->table('persona as p')
            ->leftJoin('persona_usuario_portal as pup', 'pup.persona_id', '=', 'p.id')
            ->leftJoin('turno_programado as tp', 'tp.persona_id', '=', 'p.id')
            ->leftJoin('plan as pl', 'tp.plan_id', '=', 'pl.id')
            ->leftJoin('obra_social as os', 'pl.obra_social_id', '=', 'os.id')
            ->select(
                'p.id',
                'p.documento',
                'p.apellidos',
                'p.nombres',
                'p.fecha_nacimiento',
                DB::raw("CONCAT('+',COALESCE(CAST(p.contacto_celular_prefijo AS CHAR), ''), 
                             COALESCE(CAST(p.contacto_celular_codigo AS CHAR), ''), 
                             COALESCE(CAST(p.contacto_celular_numero AS CHAR), '')) as celular"),
                'p.contacto_email_direccion as email',
                'os.nombre as obra_social' // Agregamos la obra social
            )
            ->where('p.id', $id)
            ->first());
    }

    public static function getPersonalDataByIdArray($id)
    {
        return DB::connection('db2') // Asegúrate de usar la conexión 'db2'
            ->table('persona as p')
            ->leftJoin('persona_usuario_portal as pup', 'pup.persona_id', '=', 'p.id')
            ->leftJoin('turno_programado as tp', 'tp.persona_id', '=', 'p.id')
            ->leftJoin('plan as pl', 'tp.plan_id', '=', 'pl.id')
            ->leftJoin('obra_social as os', 'pl.obra_social_id', '=', 'os.id')
            ->select(
                'p.id',
                'p.documento',
                'p.apellidos',
                'p.nombres',
                'p.fecha_nacimiento',
                DB::raw("CONCAT('+',COALESCE(CAST(p.contacto_celular_prefijo AS CHAR), ''), 
                             COALESCE(CAST(p.contacto_celular_codigo AS CHAR), ''), 
                             COALESCE(CAST(p.contacto_celular_numero AS CHAR), '')) as celular"),
                'p.contacto_email_direccion as email',
                'os.nombre as obra_social' // Agregamos la obra social
            )
            ->where('p.id', $id)
            ->first();
    }
}
