<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Bike;
use App\Models\Locacao;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index()
    {
        $clientes = Cliente::count();

        $bikes = Bike::count();

        $locacoesAtivas = Locacao::where('status', 'ativa')->count();

        $receitaMes = DB::table('pagamentos')
            ->whereMonth('created_at', now()->month)
            ->sum('valor');

        return view('relatorios.index', compact(
            'clientes',
            'bikes',
            'locacoesAtivas',
            'receitaMes'
        ));
    }
}