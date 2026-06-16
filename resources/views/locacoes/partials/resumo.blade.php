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

    <div class="card-header">
        <h3 class="card-title">Resumo</h3>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <strong>Status</strong><br>
            @include('locacoes.partials.status', ['locacao' => $locacao])
        </div>

        <div class="mb-3">
            <strong>Renovações</strong><br>
            {{ $locacao->renovacoes->count() }}
        </div>

        <div class="mb-3">
            <strong>Dias restantes</strong><br>

            @php
                $dias = now()->startOfDay()->diffInDays(
                    \Carbon\Carbon::parse($locacao->data_vencimento)->startOfDay(),
                    false
                );
            @endphp

            @if($dias < 0)
                <span class="text-danger">{{ abs($dias) }} dias atrasado</span>
            @else
                {{ $dias }} dias restantes
            @endif

        </div>

        <div class="mb-3">
            <strong>Observações</strong><br>
            {{ $locacao->observacoes ?? '-' }}
        </div>

        <hr>

        <div class="mb-3">
            <strong>Total Pago</strong><br>
            <span class="text-info">
                R$ {{ number_format($totalPago, 2, ',', '.') }}
            </span>
        </div>

        <div class="mb-3">
            <strong>Pagamentos</strong><br>
            {{ $pagamentos = Pagamento::where('locacao_id', $locacao->id)
                ->where('tipo', 'pagamento')
                ->count()
            }}
        </div>

        <div class="mb-3">
            <strong>Saldo Pendente</strong><br>

            @if($cobrancas->count() <= 0)
                <span class="badge badge-secondary">Sem cobrança</span>

            @elseif($saldoPendente <= 0)
                <span class="badge badge-success">Quitado</span>

            @elseif($totalPago > 0)
                <span class="badge badge-warning">Parcial</span>
                <span class="badge badge-danger">
                    R$ {{ number_format($saldoPendente, 2, ',', '.') }} pendente
                </span>

            @else
                <span class="badge badge-danger">Pendente</span>
                <span class="badge badge-danger">
                    R$ {{ number_format($saldoPendente, 2, ',', '.') }} pendente
                </span>
            @endif

        </div>

    </div>
</div>