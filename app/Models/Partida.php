<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $fillable = [
        'gols_time1',
        'gols_time2',
        'campeonato_id',
        'time1_id',
        'time2_id',
        'vencedor_id',
        'perdedor_id'
    ];
}
