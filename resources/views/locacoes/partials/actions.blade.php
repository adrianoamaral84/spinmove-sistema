<div class="card">

    <div class="card-header">
        <h3 class="card-title">Ações</h3>
    </div>

    <div class="card-body">

        <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $locacao->cliente->telefone) }}"
           target="_blank"
           class="btn btn-success btn-block mb-2">
            <i class="fab fa-whatsapp"></i>
            WhatsApp
        </a>

        <button type="button"
                class="btn btn-info btn-block mb-2"
                data-toggle="modal"
                data-target="#renovarModal{{ $locacao->uuid }}">
            <i class="fas fa-sync"></i>
            Renovar
        </button>

        <button class="btn btn-success btn-block mb-2"
                data-toggle="modal"
                data-target="#pagamentoModal">
            <i class="fas fa-dollar-sign"></i>
            Registrar Pagamento
        </button>

        @if($locacao->status == 'ativa')
            <button class="btn btn-warning btn-block mb-2"
                    data-toggle="modal"
                    data-target="#retiradaModal">
                <i class="fas fa-book"></i>
                Agendar Retirada
            </button>
        @endif

        @if($locacao->status == 'aguardando_retirada')
            <button class="btn btn-danger btn-block mb-2"
                    data-toggle="modal"
                    data-target="#finalizarRetiradaModal">
                <i class="fas fa-arrow-left"></i>
                Retirada realizada
            </button>
        @endif

    </div>
</div>