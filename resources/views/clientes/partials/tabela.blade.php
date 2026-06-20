@if($clientes->count())

    @foreach($clientes as $cliente)

        <tr>

            <td>

                <div class="d-flex align-items-center">

                    <div class="cliente-avatar mr-3">
                        {{ strtoupper(substr($cliente->nome,0,1)) }}
                    </div>

                    <div>

                        <strong class="d-block">
                            {{ $cliente->nome }}
                        </strong>

                        <small class="text-muted">
                            Cliente desde {{ $cliente->created_at->format('d/m/Y') }}
                        </small>

                    </div>

                </div>

            </td>

            <td class="text-center">

                <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $cliente->telefone) }}"
                   target="_blank"
                   class="btn btn-success btn-sm">

                    <i class="fab fa-whatsapp mr-1"></i>

                    {{ $cliente->telefone }}

                </a>

            </td>

            <td class="text-center">

                {{ $cliente->bairro ?? '-' }}

            </td>

            <td class="text-center">

                {{ $cliente->created_at->format('d/m/Y') }}

            </td>

            <td class="text-center">

                <span class="badge badge-info">

                    {{ $cliente->locacoes->count() }}

                </span>

            </td>

            <td class="text-center">

                <strong>

                    R$ {{ number_format($cliente->locacoes->sum('valor_mensal'), 2, ',', '.') }}

                </strong>

            </td>

            <td class="text-center">

                @if($cliente->status == 'ativo')

                    <span class="badge badge-pill badge-success">
                        ● Ativo
                    </span>

                @elseif($cliente->status == 'inativo')

                    <span class="badge badge-pill badge-secondary">
                        ● Inativo
                    </span>

                @else

                    <span class="badge badge-pill badge-danger">
                        ● Bloqueado
                    </span>

                @endif

            </td>

            <td class="text-center">



            
                

    <div class="dropdown">

       <button class="btn btn-sm btn-light border"
        data-toggle="dropdown">

    <i class="fas fa-ellipsis-v"></i>

</button>

        <div class="dropdown-menu dropdown-menu-right">

            <a class="dropdown-item"
               href="{{ route('clientes.show', $cliente) }}">

                <i class="fas fa-eye mr-2 text-info"></i>
                Visualizar

            </a>

            <a class="dropdown-item"
               href="{{ route('clientes.edit', $cliente) }}">

                <i class="fas fa-edit mr-2 text-warning"></i>
                Editar

            </a>

            <a class="dropdown-item"
               href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $cliente->telefone) }}"
               target="_blank">

                <i class="fab fa-whatsapp mr-2 text-success"></i>
                WhatsApp

            </a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item"
               href="{{ route('clientes.locacao.create',$cliente) }}?cliente={{ $cliente->uuid }}">

                <i class="fas fa-bicycle mr-2 text-primary"></i>
                Nova Locação

            </a>

        </div>

    </div>

</td>

        </tr>

    @endforeach

@else

    <tr>

        <td colspan="8" class="text-center py-4">

            Nenhum cliente encontrado.

        </td>

    </tr>

@endif