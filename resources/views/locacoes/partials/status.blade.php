@php
    $status = $locacao->status;
@endphp

@if($status == 'ativa')
    <span class="badge badge-success">Ativa</span>

@elseif($status == 'atrasada')
    <span class="badge badge-danger">Atrasada</span>

@elseif($status == 'aguardando_entrega')
    <span class="badge badge-secondary">Aguardando Entrega</span>

@elseif($status == 'aguardando_retirada')
    <span class="badge badge-warning">Aguardando Retirada</span>

@else
    <span class="badge badge-dark">Finalizada</span>
@endif