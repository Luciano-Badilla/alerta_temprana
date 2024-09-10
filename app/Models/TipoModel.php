<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class TipoModel extends Model
{
    protected $table = 'tipo';

    public $timestamps = true;

    protected $fillable = [
        'nombre'
    ];
}
