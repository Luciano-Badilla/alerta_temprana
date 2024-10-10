<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class EstadoModel extends Model
{
    protected $table = 'estados';

    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];
}
    