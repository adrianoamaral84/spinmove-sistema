<?php

namespace App\Http\Controllers;

use App\Models\Venda;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with('bike')
            ->latest()
            ->get();

        return view('vendas.index', compact('vendas'));
    }
}
