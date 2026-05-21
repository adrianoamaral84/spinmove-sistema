




@forelse($clientes ?? [] as $cliente)
<tr>
    <td><a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-info btn-sm">
        {{ $cliente->nome }}
    </a></td>
    <td>
    <a href="https://wa.me/55{{ $cliente->telefone }}"
   target="_blank" class="btn btn-success btn-sm shadow-sm">
         <i class="fab fa-whatsapp"></i> {{ $cliente->telefone }}
    </a>    
</td>
    
    
    <td align="center">
        <span class="badge bg-primary">{{ $cliente->plano->nome ?? 'Sem plano' }}</span>
    </td>
    <td align="center">

@if($cliente->data_inicio_locacao)

    {{ $cliente->data_inicio_locacao->format('d/m/Y') }}

@else

    -

@endif

</td>

<td>

@if($cliente->data_vencimento)

    {{ $cliente->data_vencimento->format('d/m/Y') }}

@else

    -

@endif

</td>
    <td align="center">

@if($cliente->status == 'aguardando_entrega')

    <span class="badge badge-warning">
        Aguardando Entrega
    </span>

@elseif($cliente->status == 'alugada')

    <span class="badge badge-success">
        Alugada
    </span>

@elseif($cliente->status == 'recolhimento')

    <span class="badge badge-info">
        Recolhimento
    </span>

@elseif($cliente->status == 'encerrada')

    <span class="badge badge-secondary">
        Encerrada
    </span>

@elseif($cliente->status == 'cancelada')

    <span class="badge badge-danger">
        Cancelada
    </span>

@else

    <span class="badge badge-dark">
        Sem Status
    </span>

@endif

</td>

    <td align="center">


@if($cliente->status_financeiro == 'em_dia')

    <span class="badge badge-success">
        Em Dia
    </span>

@elseif($cliente->status_financeiro == 'vencendo')

    <span class="badge badge-warning">
        Vencendo
    </span>

@elseif($cliente->status_financeiro == 'atrasada')

    <span class="badge badge-danger">
        Atrasada
    </span>

@elseif($cliente->status_financeiro == 'inadimplente')

    <span class="badge badge-dark">
        Inadimplente
    </span>

@else

    <span class="badge badge-secondary">
        Sem Vencimento
    </span>

@endif

</td>



    <td>

                <a href="{{ route('clientes.edit', $cliente->id) }}"
                   class="btn btn-warning btn-sm">
                   Editar
                </a>

                <form action="{{ route('clientes.destroy', $cliente->id) }}"
                      method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Excluir cliente?')">
                        Excluir
                    </button>
                </form>

    <a href="https://wa.me/55{{ $cliente->telefone }}"
   target="_blank"
   class="btn btn-success btn-sm shadow-sm">

    <i class="fab fa-whatsapp"></i>

</a>




                @if($cliente->status == 'aguardando_entrega')

<form action="{{ route('clientes.entregar-bike', $cliente->id) }}"
      method="POST"
      style="display:inline-block;">

    @csrf

    <button class="btn btn-success btn-sm shadow-sm"
        onclick="return confirm('Confirmar entrega da bike para este cliente?')">

    Entregar Bike

</button>

</form>

@endif
    @if($cliente->status == 'atrasado' || $cliente->status == 'devendo')

        @php
            $telefone = preg_replace('/\D/', '', $cliente->telefone);

            $mensagem = "Olá {$cliente->nome}, tudo bem? 😊

Verificamos que seu plano está {$cliente->status}.

Para continuar com a bike e manter seus resultados, é importante regularizar seu plano.

Qualquer dúvida estou à disposição!";
        @endphp

        <a href="https://wa.me/55{{ $telefone }}?text={{ urlencode($mensagem) }}"
           target="_blank"
           class="btn btn-success btn-sm">

           Cobrar
        </a>

    @endif
            </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">
        Nenhum cliente encontrado
    </td>
</tr>
@endforelse
