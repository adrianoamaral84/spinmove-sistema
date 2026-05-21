<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clienteId = $this->route('cliente')->id;

        return [
             'nome' => 'required|string|max:255',
            'telefone' => 'required|string|min:10|max:11',
'cpf' => 'required|string|size:11|unique:clientes,cpf,' . $clienteId,            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
'email' => 'required|email|unique:clientes,email,' . $clienteId,            'profissao' => 'required|string|max:255',
            'estado_civil' => 'required|string|max:255',
            'altura' => 'required|numeric|min:1|max:2.5',
            'origem' => 'required|string|max:255',
            'plano_id' => 'required|exists:planos,id',
            'status' => 'nullable',
'observacoes' => 'nullable',
'data_nascimento' => 'nullable|date',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),
            'telefone' => preg_replace('/\D/', '', $this->telefone),
        ]);
    }
}
