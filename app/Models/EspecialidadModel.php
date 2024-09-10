<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class EspecialidadModel extends Model
{
    protected $table = 'especialidad';

    public $timestamps = true;

    protected $fillable = [
        'nombre'
    ];
}
