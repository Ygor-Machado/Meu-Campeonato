<?php

namespace App\Http\Controllers;

use App\Models\Campeonato;
use App\Models\Time;
use Illuminate\Http\Request;

class TimeController extends Controller
{

    public Time $time;

    public function __construct(Time $time)
    {
        $this->time = $time;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $times = $this->time->all();

        return response()->json($times);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $times = $request->all();

        // Inserir vários times de uma vez no insomnia
        foreach ($times as $timeData) {
            $this->time->create($timeData);
        }

        return response()->json($times);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $time = $this->time->find($id);

        return response()->json($time);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $time = $this->time->find($id);

        $time->update($request->all());

        return response()->json($time);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $time = $this->time->find($id);

        $time->delete();

        return response()->json(['message' => 'Time deletado com sucesso!']);
    }

    public function timesCampeonatos($id)
    {
        $campeonato = Campeonato::with('times')->findOrFail($id);

        $times = $campeonato->times;

        return response()->json($times);
    }
}
