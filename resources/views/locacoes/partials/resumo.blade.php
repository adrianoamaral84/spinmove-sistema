@php
    use App\Models\Pagamento;

    $cobrancas = Pagamento::where('locacao_id', $locacao->id)
        ->where('tipo', 'cobranca')
        ->get();

    $saldoPendente = 0;

    $totalPago = Pagamento::where('locacao_id', $locacao->id)
        ->where('tipo', 'pagamento')
        ->sum('valor');

    foreach ($cobrancas as $cobranca) {

        $pagoDaCobranca = Pagamento::where('cobranca_id', $cobranca->id)
            ->where('tipo', 'pagamento')
            ->sum('valor');

        $saldo = $cobranca->valor - $pagoDaCobranca;

        if ($saldo > 0) {
            $saldoPendente += $saldo;
        }
    }
@endphp

<div class="card">

    <div class="card-body">

        <div class="section-block mb-4">

            <div class="d-flex align-items-center mb-2">

                <i class="far fa-file-alt text-primary mr-2"></i>

                <h5 class="mb-0">
                    Resumo
                </h5>

            </div>

        </div>

   <div class="resumo-row">
    <span class="resumo-label">Status</span>
    <span class="resumo-value">
        @include('locacoes.partials.status', ['locacao' => $locacao])
    </span>
</div>

<div class="resumo-row">
    <span class="resumo-label">Renovações</span>
    <span class="resumo-value">
        {{ $locacao->renovacoes->count() }}
    </span>
</div>

<div class="resumo-row">
    <span class="resumo-label">Dias Restantes</span>
    <span class="resumo-value">
        @if($dias < 0)
                    <span class="badge badge-danger">
                        {{ abs($dias) }} dias atrasado
                    </span>
                @else
                    <span class="badge badge-primary">
                        {{ $dias }} dias
                    </span>
                @endif
    </span>
</div>

<div class="resumo-row">
    <span class="resumo-label">Observações</span>
    <span class="resumo-value">
        {{ $locacao->observacoes ?? '-' }}
    </span>
</div>

        @php
            $dias = now()->startOfDay()->diffInDays(
                \Carbon\Carbon::parse($locacao->data_vencimento)->startOfDay(),
                false
            );
        @endphp

        

        
        <hr>

        <div class="resumo-row">
            <span class="resumo-label">Total Pago</span>
            <span class="resumo-value text-info">
                R$ {{ number_format($totalPago, 2, ',', '.') }}
            </span>
        </div>

        <div class="resumo-row">
            <span class="resumo-label">Pagamentos</span>
            <span class="resumo-value">
                {{ Pagamento::where('locacao_id', $locacao->id)->where('tipo', 'pagamento')->count() }}
            </span>
        </div>

        <div class="resumo-row">
            <span class="resumo-label">Saldo Pendente</span>

            <span class="resumo-value">

                @if($cobrancas->count() <= 0)

                    <span class="badge badge-secondary">
                        Sem cobrança
                    </span>

                @elseif($saldoPendente <= 0)

                    <span class="badge badge-success">
                        Quitado
                    </span>

                @else

                    <span class="badge badge-danger">
                        R$ {{ number_format($saldoPendente, 2, ',', '.') }}
                    </span>

                @endif

            </span>

        </div>

    </div>

</div>