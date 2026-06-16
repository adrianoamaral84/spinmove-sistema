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

                <div class="d-flex justify-content-center">

                    <a href="{{ route('clientes.show', $cliente) }}"
                       class="btn btn-info btn-sm mr-1"
                       title="Visualizar">

                        <i class="fas fa-eye"></i>

                    </a>

                    <a href="{{ route('clientes.edit', $cliente) }}"
                       class="btn btn-warning btn-sm mr-1"
                       title="Editar">

                        <i class="fas fa-edit"></i>

                    </a>

                    <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $cliente->telefone) }}"
                       target="_blank"
                       class="btn btn-success btn-sm mr-1"
                       title="WhatsApp">

                        <i class="fab fa-whatsapp"></i>

                    </a>

                    <a href="{{ route('clientes.locacao.create',$cliente) }}?cliente={{ $cliente->uuid }}"
                       class="btn btn-primary btn-sm"
                       title="Nova Locação">

                        <i class="fas fa-bicycle"></i>

                    </a>

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