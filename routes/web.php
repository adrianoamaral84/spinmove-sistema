<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\PagamentoController;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\CustomerFormController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\CadastroPublicoController;
use App\Http\Controllers\NotificationController;


Route::get('/', function () {
    return redirect('/dashboard');
});
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/teste-hora', function () {

   dd([
    'timezone' => config('app.timezone'),
    'now' => now()->format('d/m/Y H:i:s'),
    
]);

});

Route::middleware(['auth'])->group(function () {

Route::get('/clientes/mapa', [ClienteController::class, 'mapa'])
    ->name('clientes.mapa');

Route::get('/clientes/cobranca', [ClienteController::class, 'cobranca'])
    ->name('clientes.cobranca');

Route::get('/clientes/busca', [ClienteController::class, 'buscar'])
    ->name('clientes.buscar');

    Route::resource('clientes', ClienteController::class);
});

Route::resource('planos', PlanoController::class)->middleware('auth');

Route::post('/pagamentos', [PagamentoController::class, 'store'])
    ->name('pagamentos.store')
    ->middleware('auth');


Route::put('/pagamentos/{id}', [PagamentoController::class, 'update'])
    ->name('pagamentos.update')
    ->middleware('auth');

Route::delete('/pagamentos/{id}', [PagamentoController::class, 'destroy'])
    ->name('pagamentos.destroy')
    ->middleware('auth');


Route::get(

'/clientes/{cliente}/nova-locacao',

[LocacaoController::class,

'createCliente']

)->name(

'clientes.locacao.create'

);

Route::get('/api/clientes/cobranca', function (Request $request) {

    if ($request->header('Authorization') !== 'Bearer ' . env('API_TOKEN')) {
        return response()->json(['erro' => 'não autorizado'], 401);
    }

    return \App\Models\Cliente::all()
        ->filter(fn($c) => in_array($c->status, ['atrasado', 'devendo']))
        ->values();
});

Route::post('/api/clientes/atualizar-aviso', function (Request $request) {

    $cliente = Cliente::find($request->cliente_id);

    if ($cliente) {
        $cliente->ultimo_aviso_at = now();
        $cliente->save();
    }

    return response()->json(['ok' => true]);
});

//Route::post('/api/webhook/whatsapp', [WebhookController::class, 'receberMensagem']);
Route::post('/webhook/whatsapp', [WebhookController::class, 'receber']);

Route::get('/cadastro/{token}', [CustomerFormController::class, 'show']);
Route::post('/cadastro/{token}', [CustomerFormController::class, 'store']);

Route::post('/clientes/{cliente}/entregar-bike',
    [ClienteController::class, 'entregarBike'])
    ->name('clientes.entregar-bike');


Route::post('/bikes/vender', [BikeController::class, 'vender'])
    ->name('bikes.vender');

Route::resource('bikes', \App\Http\Controllers\BikeController::class);

Route::get('/vendas', [VendaController::class, 'index'])
    ->name('vendas.index');




Route::post(
    '/locacoes/{locacao}/entregar',
    [LocacaoController::class, 'entregar']
)->name('locacoes.entregar');

Route::post(
    '/locacoes/{locacao}/pagamento',
    [LocacaoController::class, 'registrarPagamento']
)->name('locacoes.pagamento');

    Route::post('/locacoes/{locacao}/devolver',
    [LocacaoController::class, 'devolver'])
    ->name('locacoes.devolver');

    Route::post('/locacoes/{locacao}/renovar',
    [LocacaoController::class, 'renovar'])
    ->name('locacoes.renovar');

    Route::resource('locacoes', LocacaoController::class);

Route::get(

    '/financeiro',

    [FinanceiroController::class,'index']

)->name('financeiro.index');


Route::post('/locacoes/{locacao}/retirada',[LocacaoController::class,'agendarRetirada'])->name('locacoes.agendarRetirada');
Route::post('/locacoes/{locacao}/finalizar-retirada',[LocacaoController::class,'finalizarRetirada'])->name('locacoes.finalizarRetirada');


//Public
Route::get('/cadastro-cliente',[CadastroPublicoController::class,'create'])->name('cadastro.publico');
Route::post('/cadastro-cliente',[CadastroPublicoController::class,'store'])->name('cadastro.publico.store');


Route::post(

'/notificacoes/{id}/lida',

[

NotificationController::class,

'marcar'

]

)->middleware(
'auth'
);





Route::post('/bikes/lote',[BikeController::class,'storeLote'])->name('bikes.lote.store');

Route::get('/relatorios', [App\Http\Controllers\RelatorioController::class, 'index'])
    ->name('relatorios.index');


require __DIR__.'/auth.php';