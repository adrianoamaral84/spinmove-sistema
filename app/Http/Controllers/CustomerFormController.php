<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerFormController extends Controller
{
    public function show($token)
{
    $form = CustomerForm::where('token', $token)
        ->where('status', 'pending')
        ->firstOrFail();

    return view('cadastro.customer-form', compact('form'));
}

public function store(Request $request, $token)
{
    $form = CustomerForm::where('token', $token)->firstOrFail();

    Customer::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'cpf' => $request->cpf,
    ]);

    $form->update([
        'status' => 'completed'
    ]);

    return redirect()->back()->with('success', 'Cadastro realizado!');
}
}
