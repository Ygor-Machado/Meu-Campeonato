<?php

namespace App\Http\Controllers;

use App\Models\Campeonato;
use App\Models\Partida;
use App\Models\Time;
use App\Services\CampeonatoService;
use Illuminate\Http\Request;

class CampeonatoController extends Controller
{

    protected $campeonatoService;
    protected $campeonato;

    public function __construct(CampeonatoService $campeonatoService, Campeonato $campeonato)
    {
        $this->campeonatoService = $campeonatoService;
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

    public function simularPartidas($id)
    {
       $campeonato = $this->campeonatoService->simularPartidas($id);

       return response()->json($campeonato);
    }


    public function mostrarResultado($id)
    {
        $campeonato = $this->campeonatoService->mostrarResultado($id);

        return response()->json($campeonato);
    }
}
