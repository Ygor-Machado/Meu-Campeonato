<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campeonato extends Model
{
    use HasFactory;

    protected $fillable = [
        "nome",
    ];

    public function times()
    {
        return $this->hasMany(Time::class);
    }

    public function partidas()
    {
        return $this->hasMany(Partida::class);
    }
}
