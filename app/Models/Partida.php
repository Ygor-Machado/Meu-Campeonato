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

    public function campeonato()
    {
        return $this->belongsTo(Campeonato::class);
    }

    public function time1()
    {
        return $this->belongsTo(Time::class, 'time1_id');
    }

    public function time2()
    {
        return $this->belongsTo(Time::class, 'time2_id');
    }

    public function vencedor()
    {
        return $this->belongsTo(Time::class, 'vencedor_id');
    }

    public function perdedor()
    {
        return $this->belongsTo(Time::class, 'perdedor_id');
    }
}
