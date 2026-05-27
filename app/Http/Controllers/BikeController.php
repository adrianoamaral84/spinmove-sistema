<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Locacao;

class BikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {

    $totalBikes = Bike::count();

$disponiveis =

Bike::where(
'status',
'disponivel'
)->count();


$alugadas =

Bike::where(
'status',
'alugada'
)->count();


$reservadas =

Bike::where(
'status',
'reservada'
)->count();


$vendidas =

Bike::where(
'status',
'vendida'
)->count();


$manutencao =

Bike::where(
'status',
'manutencao'
)->count();


        $bikes = Bike::latest()->get();


$proximasRetiradas =

Locacao::

with(

'cliente',

'bike'

)

->where(

'status',

'aguardando_retirada'

)

->orderBy(

'data_vencimento'

)

->take(5)

->get();

        return view(

'bikes.index',

compact(

'bikes',

'totalBikes',

'disponiveis',

'alugadas',

'reservadas',

'vendidas',

'proximasRetiradas',

'manutencao'

)

);
    }

    public function create()
    {
        return view('bikes.create');
    }

    public function store(Request $request)
{
    $ultimaBike = Bike::latest()->first();

    $numero = 1;

    if ($ultimaBike) {

        $ultimoCodigo = intval(
            str_replace('BK-', '', $ultimaBike->codigo)
        );

        $numero = $ultimoCodigo + 1;
    }

    $codigo = 'BK-' . str_pad($numero, 4, '0', STR_PAD_LEFT);

    Bike::create([

        'codigo' => $codigo,

        'modelo' => $request->modelo,

        'marca' => $request->marca,

        'status' => $request->status,

        'observacoes' => $request->observacoes,
  
        'valor_compra' => $request->valor_compra,
        
        'data_compra' => $request->data_compra,

        

    ]);

    return redirect()
        ->route('bikes.index')
        ->with('success', 'Bike cadastrada com sucesso!');
}
    /**
     * Display the specified resource.
     */
    public function show(Bike $bike)
{

    $locacoes = $bike
        ->locacoes()
        ->with('cliente')
        ->latest()
        ->get();

    return view(

        'bikes.show',

        compact(
            'bike',
            'locacoes'
        )

    );

}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bike $bike)
{
    return view('bikes.edit', compact('bike'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bike $bike)
{
    $bike->update($request->all());

    return redirect()
        ->route('bikes.index')
        ->with('success', 'Bike atualizada com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bike $bike)
    {
        //
    }

   
public function vender(Request $request)
{
    $bike = Bike::findOrFail($request->bike_id);

    // Cria registro da venda
    Venda::create([
        'bike_id' => $bike->id,
        'valor' => $request->valor_venda,
        'cliente' => $request->cliente,
        'observacoes' => $request->observacoes,
        'data_venda' => now(),
    ]);

    // Atualiza status da bike
    $bike->status_patrimonial = 'vendida';
    $bike->status = 'inativa';
    $bike->save();

    return redirect()->back()
        ->with('success', 'Bike vendida com sucesso!');
}


public function storeLote(Request $request)
{
    $data = $request->validate([
        'quantidade' => 'required|integer|min:1',
        'marca' => 'required',
        'modelo' => 'required',
        'valor_compra' => 'nullable',
        'data_compra' => 'nullable',
        'status' => 'required'
    ]);

    $ultimoId =
        Bike::max('id') ?? 0;

    for(
        $i=1;
        $i <= $data['quantidade'];
        $i++
    ){

        $numero =
            $ultimoId + $i;

        Bike::create([

           'codigo' =>

strtoupper(
    $request->prefixo ?? 'SM'
)

.'-'.

str_pad(
    $numero,
    3,
    '0',
    STR_PAD_LEFT
),

            'modelo'=>
            $data['modelo'],

            'marca'=>
            $data['marca'],

            'valor_compra'=>
            $data['valor_compra'],

            'data_compra'=>
            $data['data_compra'],

            'status'=>
            $data['status']

        ]);

    }

    return response()->json([

        'message'=>

        $data['quantidade']

        .' bikes criadas'

    ]);
}

}
