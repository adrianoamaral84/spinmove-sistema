<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $planos = \App\Models\Plano::latest()->get();
    return view('planos.index', compact('planos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('planos.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nome' => 'required',
        'valor' => 'required|numeric',
        'duracao_dias' => 'required|integer'
    ]);

    \App\Models\Plano::create($request->all());

    return redirect()->route('planos.index')->with('success', 'Plano criado com sucesso');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $plano = \App\Models\Plano::findOrFail($id);
    return view('planos.edit', compact('plano'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $plano = \App\Models\Plano::findOrFail($id);

    $plano->update($request->all());

    return redirect()->route('planos.index')->with('success', 'Plano atualizado');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $plano = \App\Models\Plano::findOrFail($id);
    $plano->delete();

    return redirect()->route('planos.index')->with('success', 'Plano excluído');
}
}
