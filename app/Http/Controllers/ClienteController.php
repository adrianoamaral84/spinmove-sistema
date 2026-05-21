<?php

namespace App\Http\Controllers;


use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Carbon\Carbon;
use App\Models\Plano;
use App\Models\Conversa;
use App\Models\Mensagem;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{

    $clientes = Cliente::with(
        'plano',
        'pagamentos'
    );

    if ($request->filled('busca')) {

        $clientes->where(

            function($query)
            use($request){

                $query
                ->where(
                    'nome',
                    'like',
                    '%'.$request->busca.'%'
                )

                ->orWhere(
                    'telefone',
                    'like',
                    '%'.$request->busca.'%'
                );

            }

        );

    }


    if ($request->status) {

        $clientes->where(

            'status',

            $request->status

        );

    }


    $clientes =

        $clientes

        ->latest()

        ->paginate(20);



    // KPIs CLIENTES

    $totalClientes =

        Cliente::count();


    $clientesAtivos =

        Cliente::where(

            'status',

            'ativo'

        )->count();



    $inadimplentes =

        Cliente::all()

        ->filter(

            fn($cliente)

            =>

            $cliente

            ->status_financeiro

            ==

            'inadimplente'

        )

        ->count();



    $novosMes =

        Cliente::whereMonth(

            'created_at',

            now()->month

        )

        ->count();



    $ticketMedio =

        \App\Models\Pagamento::

        where(

            'tipo',

            'pagamento'

        )

        ->sum(

            'valor'

        )

        /

        max(

            1,

            Cliente::count()

        );



    $clientesRecentes =

        Cliente::

        latest()

        ->take(5)

        ->get();



    $origens =

        Cliente::

        selectRaw(

            'origem,

            count(*) total'

        )

        ->groupBy(

            'origem'

        )

        ->get();

    $novos7Dias =

Cliente::

where(

'created_at',

'>=',

now()->subDays(7)

)

->latest()

->take(10)

->get();

    return view(

        'clientes.index',

        compact(

            'clientes',

            'totalClientes',

            'clientesAtivos',

            'novos7Dias',

            'inadimplentes',

            'novosMes',

            'ticketMedio',

            'clientesRecentes',

            'origens'

        )

    );

}
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        date_default_timezone_set('America/Sao_Paulo');

    $planos = \App\Models\Plano::all();
    return view('clientes.create', compact('planos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
{
date_default_timezone_set('America/Sao_Paulo');

   $clienteExistente = Cliente::where('cpf', $request->cpf)->first();

    if ($clienteExistente) {
        return response()->json([
            'message' => 'Cliente já cadastrado',
            'cliente' => $clienteExistente
        ]);
    }


    $plano = Plano::find($request->plano_id);

$dataVencimento = null;

if ($plano) {
    $dataVencimento = Carbon::today()
        ->addDays($plano->duracao_dias)
        ->format('Y-m-d');
}

$conversa = Conversa::where('telefone', $request->telefone)->first();
$data = $request->validated();

//$data['data_vencimento'] = $dataVencimento;
$data['conversa_id'] = $conversa->id ?? null;

/*
// Comeco codigo maps
$endereco = $request->endereco . ', ' .
             $request->bairro;
             

$apiKey = env('GOOGLE_MAPS_API_KEY');

$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" .
        urlencode($endereco) .
        "&key={$apiKey}";

$response = file_get_contents($url);

$data = json_decode($response, true);

$latitude = null;
$longitude = null;

if (!empty($data['results'])) {

    $latitude =
        $data['results'][0]['geometry']['location']['lat'];

    $longitude =
        $data['results'][0]['geometry']['location']['lng'];
}
// Final codigo maps
dd($response);
*/
Cliente::create($data);


    //Cliente::create($request->validated());

    return redirect()->route('clientes.index')
    ->with('success', 'Cliente cadastrado com sucesso!');
}

    
    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $cliente = Cliente::findOrFail($id);
    
    return view('clientes.show', compact('cliente'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
{
    $planos = Plano::all();

    return view('clientes.edit', compact('cliente', 'planos'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
{

date_default_timezone_set('America/Sao_Paulo');

    $data = $request->validated();

    if ($request->plano_id) {

        $plano = Plano::find($request->plano_id);

        $data['data_vencimento'] = now()
            ->addDays($plano->duracao_dias)
            ->format('Y-m-d');
    }

    //dd($cliente->getDirty());

$cliente->update($data);

    return redirect()->route('clientes.index')
        ->with('success', 'Cliente atualizado com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Cliente $cliente)
{
    $cliente->delete();

    return redirect()->route('clientes.index')
        ->with('success', 'Cliente excluído com sucesso!');
}
public function buscar(Request $request)
{
    
    $clientes = Cliente::query()
        ->where('nome', 'like', '%' . $request->busca . '%')
        ->orWhere('telefone', 'like', '%' . $request->busca . '%')
        ->limit(20)
        ->get();
    
    return view('clientes.partials.tabela', compact('clientes'))->render();
}

public function cobranca()
{
    $clientes = \App\Models\Cliente::all()->filter(function ($cliente) {
        return in_array($cliente->status, ['atrasado', 'devendo']);
    });

    return view('clientes.cobranca', compact('clientes'));
}

public function entregarBike(Cliente $cliente)
{

date_default_timezone_set('America/Sao_Paulo');

    if (!$cliente->plano) {

        return back()->with('error', 'Cliente sem plano.');
    }

    $cliente->status = 'alugada';

    $cliente->data_inicio_locacao = now();

    $cliente->data_vencimento = now()
        ->addDays($cliente->plano->duracao_dias);
    
        $cliente->save();

    return back()->with('success', 'Bike entregue com sucesso!');
}

public function mapa()
{
    $clientes = Cliente::with(['locacoes' => function ($q) {

    $q->latest();

}])

->whereNotNull('latitude')
->whereNotNull('longitude')
->get();

    return view('clientes.mapa', compact('clientes'));
}

}
