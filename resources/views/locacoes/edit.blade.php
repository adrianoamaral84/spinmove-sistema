@extends('adminlte::page')

@section('title', 'Editar Locação')

@section('css')
<link rel="stylesheet" href="{{ asset('spinmove/css/spinmove.css') }}">
@stop

@section('content')

{{-- =========================
    HEADER
========================= --}}
<div class="content-header section-block">
    <h3 class="mb-0">Editar Locação</h3>
    <small class="text-muted">
        Atualize os dados da locação
    </small>
</div>

{{-- =========================
    FORM
========================= --}}
<div class="section-block">

    <div class="card">

        <div class="card-body">

            <form action="{{ route('locacoes.update', $locacao->uuid) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- CLIENTE --}}
                    <div class="col-md-6 mb-3">
                        <label>Cliente</label>
                        <select name="cliente_id" class="form-control" required>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ $locacao->cliente_id == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- BIKE --}}
                    <div class="col-md-6 mb-3">
                        <label>Bike</label>
                        <select name="bike_id" class="form-control" required>
                            @foreach($bikes as $bike)
                                <option value="{{ $bike->id }}"
                                    {{ $locacao->bike_id == $bike->id ? 'selected' : '' }}>
                                    {{ $bike->modelo }} ({{ $bike->codigo }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PLANO --}}
                    <div class="col-md-6 mb-3">
                        <label>Plano</label>
                        <select name="plano_id" class="form-control" required>
                            @foreach($planos as $plano)
                                <option value="{{ $plano->id }}"
                                    {{ $locacao->plano_id == $plano->id ? 'selected' : '' }}>
                                    {{ $plano->nome }} - R$ {{ number_format($plano->valor,2,',','.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- VALOR --}}
                    <div class="col-md-6 mb-3">
                        <label>Valor Mensal</label>
                        <input type="number"
                               step="0.01"
                               name="valor_mensal"
                               class="form-control"
                               value="{{ $locacao->valor_mensal }}">
                    </div>

                    {{-- DATA INICIO --}}
                    <div class="col-md-6 mb-3">
                        <label>Data Início</label>
                        <input type="date"
                               name="data_inicio"
                               class="form-control"
                               value="{{ $locacao->data_inicio }}">
                    </div>

                    {{-- DATA VENCIMENTO --}}
                    <div class="col-md-6 mb-3">
                        <label>Data Vencimento</label>
                        <input type="date"
                               name="data_vencimento"
                               class="form-control"
                               value="{{ $locacao->data_vencimento }}">
                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">

                            <option value="ativa"
                                {{ $locacao->status == 'ativa' ? 'selected' : '' }}>
                                Ativa
                            </option>

                            <option value="atrasada"
                                {{ $locacao->status == 'atrasada' ? 'selected' : '' }}>
                                Atrasada
                            </option>

                            <option value="aguardando_entrega"
                                {{ $locacao->status == 'aguardando_entrega' ? 'selected' : '' }}>
                                Aguardando Entrega
                            </option>

                            <option value="aguardando_retirada"
                                {{ $locacao->status == 'aguardando_retirada' ? 'selected' : '' }}>
                                Aguardando Retirada
                            </option>

                            <option value="finalizada"
                                {{ $locacao->status == 'finalizada' ? 'selected' : '' }}>
                                Finalizada
                            </option>

                        </select>
                    </div>

                    {{-- OBSERVAÇÕES --}}
                    <div class="col-md-12 mb-3">
                        <label>Observações</label>
                        <textarea name="observacoes"
                                  class="form-control"
                                  rows="3">{{ $locacao->observacoes }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end">

                    <a href="{{ route('locacoes.index') }}"
                       class="btn btn-light mr-2">
                        Cancelar
                    </a>

                    <button class="btn btn-success">
                        Atualizar Locação
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@stop