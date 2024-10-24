<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class RolModel extends Model
{
    protected $table = 'rol';

    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];
}
    