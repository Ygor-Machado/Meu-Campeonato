<?php

namespace App\Services;

use App\Models\Campeonato;
use App\Models\Partida;
use App\Models\Time;

class CampeonatoService
{
    protected $partida;
    protected $campeonato;

    public function __construct(Partida $partida, Campeonato $campeonato)
    {
        $this->partida = $partida;
        $this->campeonato = $campeonato;
    }

    public function simularPartidas($id)
    {
        $campeonato = $this->campeonato->findOrFail($id);

        if ($campeonato->times->count() !== 8) {
            return ['error' => 'O campeonato deve ter exatamente 8 times para ser simulado, remova um time para simular o campeonato'];
        }

        $times = $campeonato->times->pluck('id')->shuffle();

        // Quartas de finais
        for ($i = 0; $i < 4; $i++) {
            $this->partida->create([
                'campeonato_id' => $campeonato->id,
                'time1_id' => $times[$i * 2],
                'time2_id' => $times[$i * 2 + 1],
                'vencedor_id' => null,
                'perdedor_id' => null,
                'gols_time1' => rand(0, 9),
                'gols_time2' => rand(0, 9),
            ]);
        }

        $this->atualizarVencedores($campeonato);

        $vencedoresQuartas = $this->partida->where('campeonato_id', $campeonato->id)
            ->whereNotNull('vencedor_id')
            ->orderBy('id')
            ->pluck('vencedor_id')
            ->shuffle();

        // Semifinais
        for ($i = 0; $i < 2; $i++) {
            $this->partida->create([
                'campeonato_id' => $campeonato->id,
                'time1_id' => $vencedoresQuartas[$i * 2],
                'time2_id' => $vencedoresQuartas[$i * 2 + 1],
                'vencedor_id' => null,
                'perdedor_id' => null,
                'gols_time1' => rand(0, 9),
                'gols_time2' => rand(0, 9),
            ]);
        }

        $this->atualizarVencedores($campeonato);

        // Obter os vencedores das semifinais
        $vencedoresSemifinais = $this->partida->where('campeonato_id', $campeonato->id)
            ->whereNotNull('vencedor_id')
            ->orderBy('id', 'desc')
            ->take(2)
            ->pluck('vencedor_id');

        // Simulação da final
        $this->partida->create([
            'campeonato_id' => $campeonato->id,
            'time1_id' => $vencedoresSemifinais[0],
            'time2_id' => $vencedoresSemifinais[1],
            'vencedor_id' => null,
            'perdedor_id' => null,
            'gols_time1' => rand(0, 9),
            'gols_time2' => rand(0, 9),
        ]);

        // Atualizar vencedores e identificar o campeão
        $this->atualizarVencedores($campeonato);

        $final = $this->partida->where('campeonato_id', $campeonato->id)
            ->orderBy('id', 'desc')
            ->first();
        $campeao = Time::find($final->vencedor_id);

        // Obter as partidas por fase
        $quartas = $this->partida->where('campeonato_id', $campeonato->id)
            ->orderBy('id')
            ->take(4)
            ->get();

        $semifinais = $this->partida->where('campeonato_id', $campeonato->id)
            ->orderBy('id')
            ->skip(4)
            ->take(2)
            ->get();

        $final = $this->partida->where('campeonato_id', $campeonato->id)
            ->orderBy('id', 'desc')
            ->first();

        return [
            'campeonato' => $campeonato,
            'quartas_de_final' => $quartas,
            'semifinais' => $semifinais,
            'final' => $final,
            'campeao' => $campeao,
        ];
    }

    public function mostrarResultado($id)
    {

        $campeonato = $this->campeonato->with('times')->findOrFail($id);

        $partidas = $this->partida->where('campeonato_id', $campeonato->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $quartas_de_final = $partidas->filter(function ($partida) {
            return $partida->id <= 4;
        });

        $semifinais = $partidas->filter(function ($partida) {
            return $partida->id > 4 && $partida->id <= 6;
        });

        $final = $partidas->filter(function ($partida) {
            return $partida->id == 7;
        })->first();

        $campeao = Time::find($final->vencedor_id);

        return response()->json([
            'campeonato' => $campeonato,
            'quartas_de_final' => $quartas_de_final,
            'semifinais' => $semifinais,
            'final' => $final,
            'campeao' => $campeao,
        ], 200);
    }

    private function atualizarVencedores(Campeonato $campeonato)
    {
        $partidas = $this->partida->where('campeonato_id', $campeonato->id)
            ->whereNull('vencedor_id')
            ->get();

        foreach ($partidas as $partida) {
            $this->calcularResultado($partida);
        }
    }

    private function calcularResultado(Partida $partida)
    {
        $pontos_time1 = $partida->gols_time1 - $partida->gols_time2;
        $pontos_time2 = $partida->gols_time2 - $partida->gols_time1;

        if ($partida->gols_time1 > $partida->gols_time2) {
            $partida->vencedor_id = $partida->time1_id;
            $partida->perdedor_id = $partida->time2_id;
        } elseif ($partida->gols_time2 > $partida->gols_time1) {
            $partida->vencedor_id = $partida->time2_id;
            $partida->perdedor_id = $partida->time1_id;
        } else {
            $pontos_time1 = $partida->gols_time1 - $partida->gols_time2;
            $pontos_time2 = $partida->gols_time2 - $partida->gols_time1;

            if ($pontos_time1 > $pontos_time2) {
                $partida->vencedor_id = $partida->time1_id;
                $partida->perdedor_id = $partida->time2_id;
            } else {
                $partida->vencedor_id = $partida->time2_id;
                $partida->perdedor_id = $partida->time1_id;
            }
        }

        $time1 = Time::find($partida->time1_id);
        $time2 = Time::find($partida->time2_id);

        $time1->pontos += $pontos_time1;
        $time2->pontos += $pontos_time2;

        $time1->save();
        $time2->save();

        $partida->save();
    }
}
