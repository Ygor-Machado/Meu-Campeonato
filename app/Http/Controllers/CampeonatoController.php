<?php

namespace App\Http\Controllers;

use App\Models\Campeonato;
use App\Models\Partida;
use Illuminate\Http\Request;

class CampeonatoController extends Controller
{

    public Campeonato $campeonato;

    public function __construct(Campeonato $campeonato)
    {
        $this->campeonato = $campeonato;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campeonatos = $this->campeonato->all();

        return response()->json($campeonatos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $campeonato = $this->campeonato->create($request->all());

        return response()->json($campeonato);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $campeonato = $this->campeonato->find($id);

        return response()->json($campeonato);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $campeonato = $this->campeonato->find($id);

        $campeonato->update($request->all());

        return response()->json($campeonato);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $campeonato = $this->campeonato->find($id);

        $campeonato->delete();

        return response()->json(["message" => "Campeonato Removido com Sucesso"], 204);
    }

    public function gerarPartidas($id)
    {
        $campeonato = Campeonato::findOrFail($id);

        if ($campeonato->times()->count() != 8) {
            return response()->json(['error' => 'O campeonato deve ter exatamente 8 times'], 400);
        }

        $times = $campeonato->times->shuffle();

        // Quartas de final
        for ($i = 0; $i < 4; $i++) {
            Partida::create([
                'campeonato_id' => $campeonato->id,
                'time1_id' => $times[$i * 2]->id,
                'time2_id' => $times[$i * 2 + 1]->id,
                'gols_time1' => 0,
                'gols_time2' => 0,
                'vencedor_id' => null,
                'perdedor_id' => null,
            ]);
        }

        return response()->json($campeonato->partidas, 201);
    }
}
