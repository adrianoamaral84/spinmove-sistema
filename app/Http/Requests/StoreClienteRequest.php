<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|min:10|max:11',
            'cpf' => 'required|string|size:11|unique:clientes,cpf',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'profissao' => 'required|string|max:255',
            'estado_civil' => 'required|string|max:255',
            'altura' => 'required|numeric|min:1|max:2.5',
            'origem' => 'required|string|max:255',
            'plano_id' => 'required|exists:planos,id',
            'status' => 'nullable',
'observacoes' => 'nullable',
'data_nascimento' => 'nullable|date',
'numero' => 'nullable|string|max:20',
'cidade' => 'required|string|max:100',
'cep' => 'required|string|size:8',

        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório',
            'telefone.required' => 'O telefone é obrigatório',
            'cpf.required' => 'O CPF é obrigatório',
            'cpf.size' => 'O CPF deve ter 11 dígitos',
            'cpf.unique' => 'Esse CPF já está cadastrado',
            'email.email' => 'Email inválido',
            'email.unique' => 'Esse email já está cadastrado',
            'endereco.required' => 'O endereco é obrigatório',
            'bairro.required' => 'O bairro é obrigatório',
            'profissao.required' => 'O campo profissao é obrigatório',
            'estado_civil.required' => 'O campo estado civil é obrigatório',
            'altura.required' => 'O campo altura é obrigatório',
            'altura.numeric' => 'O campo é somente números!',
            'origem.required' => 'Campo obrigatório',
            'plano.required' => 'Campo obrigatório',
            'email.required' => 'Campo obrigatório',
            'numero.required' => 'O número é obrigatório',
            'numero.max' => 'O número não pode exceder 20 caracteres',
            'cidade.required' => 'A cidade é obrigatória',
            'cep.required' => 'O CEP é obrigatório',
        ];
    }

     protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),
            'telefone' => preg_replace('/\D/', '', $this->telefone),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->validarCpf($this->cpf)) {
                $validator->errors()->add('cpf', 'CPF inválido');
            }
        });
    }

    private function validarCpf($cpf)
    {
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;

            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) return false;
        }

        return true;
    }
}