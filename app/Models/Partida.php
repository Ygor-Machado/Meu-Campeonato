<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $fillable = [
        'gols_time_1',
        'gols_time_2',
        'campeonato_id',
        'time_1_id',
        'time_2_id',
        'fase_id',
        'vencedor_id',
        'perdedor_id'
    ];
}
