@php
use App\Support\HistoricoEventos;
@endphp


@switch($evento)

    @case(HistoricoEventos::CADASTRO_REALIZADO)
        <i class="fas fa-user-plus text-success"></i>
        @break

    @case(HistoricoEventos::CLIENTE_ATUALIZADO)
        <i class="fas fa-user-edit text-primary"></i>
        @break

    @case(HistoricoEventos::CLIENTE_APROVADO)
        <i class="fas fa-check-circle text-success"></i>
        @break

    @case(HistoricoEventos::CLIENTE_EXCLUIDO)
        <i class="fas fa-user-times text-danger"></i>
        @break

    @case(HistoricoEventos::TERMO_ACEITO)
        <i class="fas fa-file-signature text-warning"></i>
        @break

    @case(HistoricoEventos::BIKE_VINCULADA)
        <i class="fas fa-bicycle text-primary"></i>
        @break

    @case(HistoricoEventos::BIKE_ENTREGUE)
        <i class="fas fa-truck text-info"></i>
        @break

    @case(HistoricoEventos::AGUARDANDO_RETIRADA)
        <i class="fas fa-clock text-warning"></i>
        @break

    @case(HistoricoEventos::RETIRADA_FINALIZADA)
        <i class="fas fa-box-open text-success"></i>
        @break

    @case(HistoricoEventos::PAGAMENTO_RECEBIDO)
        <i class="fas fa-dollar-sign text-success"></i>
        @break

    @case(HistoricoEventos::COBRANCA_ENVIADA)
        <i class="fas fa-exclamation-triangle text-danger"></i>
        @break

    @case(HistoricoEventos::PAGAMENTO_REGISTRADO)
        <i class="fas fa-dollar-sign text-primary"></i>
        @break

    @case(HistoricoEventos::LOCACAO_RENOVADA)
        <i class="fas fa-sync-alt text-info"></i>
        @break

    @case(HistoricoEventos::LOCACAO_CRIADA)
        <i class="fas fa-plus-circle text-success"></i>
        @break

    @case(HistoricoEventos::BIKE_DEVOLVIDA)
        <i class="fas fa-undo text-warning"></i>
        @break

    @case(HistoricoEventos::BIKE_ENTREGUE)
        <i class="fas fa-truck text-info"></i>
        @break

    @case(HistoricoEventos::RETIRADA_AGENDADA)
        <i class="fas fa-calendar-alt text-info"></i>
        @break

    @default
        <i class="fas fa-circle text-secondary"></i>

@endswitch