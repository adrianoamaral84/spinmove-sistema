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
use App\Models\Notification;
use App\Services\ClienteService;
use App\Models\ClienteHistorico;
use App\Services\HistoricoService;  
use Illuminate\Validation\ValidationException; 


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
   public function store(StoreClienteRequest $request, ClienteService $service)
{
    
try {

    $cliente = $service->criar(
        $request->validated()
    );

} catch (\Exception $e) {

    return back()
        ->withInput()
        ->withErrors([
            'cpf' => $e->getMessage()
        ]);

}
    
    

   
    HistoricoService::registrar(
    $cliente->id,
    HistoricoEventos::CADASTRO_REALIZADO,
    'Cadastro enviado pelo formulário interno'
);

    return redirect()
        ->route('clientes.index')
        ->with('success', 'Cliente cadastrado com sucesso!');
}

    
    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
{

$locacaoAtiva = $cliente->locacoes()
    ->where('status', 'ativa')
    ->latest()
    ->first();

$bikeAtual = $locacaoAtiva?->bike?->marca ?? '-';

$vencimento = $locacaoAtiva?->data_fim;

$diasAtraso = 0;

if ($vencimento && now()->gt($vencimento)) {
    $diasAtraso = now()->diffInDays($vencimento);
}

$valorPendente = $cliente->locacoes
    ->sum(function ($locacao) {
        return max(
            0,
            ($locacao->valor_total ?? 0)
            - ($locacao->pagamentos->sum('valor') ?? 0)
        );
    });

    $alertas = [];

if ($valorPendente > 0) {

    $alertas[] = [
        'tipo' => 'danger',
        'texto' => 'Cliente possui R$ '
            . number_format($valorPendente,2,',','.')
            . ' em aberto'
    ];
}

if ($diasAtraso > 0) {

    $alertas[] = [
        'tipo' => 'danger',
        'texto' => 'Pagamento atrasado há '
            . $diasAtraso
            . ' dias'
    ];
}

if ($vencimento) {

    $diasParaVencer =
        now()->diffInDays(
            $vencimento,
            false
        );

    if (
        $diasParaVencer >= 0 &&
        $diasParaVencer <= 7
    ) {

        $alertas[] = [
            'tipo' => 'warning',
            'texto' => 'Contrato vence em '
                . $diasParaVencer
                . ' dias'
        ];
    }
}

    return view(
    'clientes.show',
    compact(
        'cliente',
        'alertas',
        'bikeAtual',
        'vencimento',
        'valorPendente',
        'diasAtraso',
        'locacaoAtiva'
            )
);
    

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


 HistoricoService::registrar(
    $cliente->id,
    HistoricoEventos::CLIENTE_ATUALIZADO,
    'Cliente atualizado com sucesso'
);
    return redirect()->route('clientes.index')
        ->with('success', 'Cliente atualizado com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Cliente $cliente)
{
    $cliente->delete();
    
    HistoricoService::registrar(
    $cliente->id,
    HistoricoEventos::CLIENTE_EXCLUIDO,
    'Cliente excluído do sistema'
);
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
 HistoricoService::registrar(
    $cliente->id,
    HistoricoEventos::BIKE_ENTREGUE,
    'Entrega realizada por '.auth()->user()->name
);
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
