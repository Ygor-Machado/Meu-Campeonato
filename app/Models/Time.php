<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'campeonato_id'
    ];

    public function campeonato()
    {
        return $this->belongsTo(Campeonato::class);
    }

    public function partidas1()
    {
        return $this->hasMany(Partida::class, 'time1_id');
    }

    public function partidas2()
    {
        return $this->hasMany(Partida::class, 'time2_id');
    }
}
