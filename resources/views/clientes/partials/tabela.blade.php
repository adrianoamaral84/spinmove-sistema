@if($clientes->count())

            @foreach($clientes as $cliente)

            <tr>

                <td>

                    <strong>
                        {{ $cliente->nome }}
                    </strong>

                </td>

                <td style="text-align: center;">

                    <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $cliente->telefone) }}"
                       target="_blank"
                       class="btn btn-success btn-sm">

                        <i class="fab fa-whatsapp"></i>

                        {{ $cliente->telefone }}

                    </a>

                </td>

                <td style="text-align: center;">

                    {{ $cliente->bairro ?? '-' }}

                </td>

                <td style="text-align: center;">

                    {{ $cliente->created_at->format('d/m/Y') }}

                </td>

                <td style="text-align: center;">

                    <span class="badge badge-info">

                        {{ $cliente->locacoes->count() }}

                    </span>

                </td>

                <td style="text-align: center;">

                    R$
                    {{ number_format($cliente->locacoes->sum('valor_mensal'), 2, ',', '.') }}

                </td>

                <td style="text-align: center;">

                    @if($cliente->status == 'ativo')

                        <span class="badge badge-success">
                            Ativo
                        </span>

                    @elseif($cliente->status == 'inativo')

                        <span class="badge badge-secondary">
                            Inativo
                        </span>

                    @else

                        <span class="badge badge-danger">
                            Bloqueado
                        </span>

                    @endif

                </td>

                <td style="text-align: center;">

                    <div class="d-flex align-items-center">

                        <a href="{{ route('clientes.show', $cliente) }}"
                           class="btn btn-info btn-sm mr-1">

                            <i class="fas fa-eye"></i>

                        </a>

                        <a href="{{ route('clientes.edit', $cliente) }}"
                           class="btn btn-warning btn-sm mr-1">

                            <i class="fas fa-edit"></i>

                        </a>

                        <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $cliente->telefone) }}"
                           target="_blank"
                           class="btn btn-success btn-sm mr-1">

                            <i class="fab fa-whatsapp"></i>

                        </a>

                        <a href="{{ route('clientes.locacao.create',$cliente) }}?cliente={{ $cliente->uuid }}"
                           class="btn btn-primary btn-sm">

                            <i class="fas fa-plus"></i>

                        </a>

                    </div>

                </td>

            </tr>

            @endforeach

        @else

            <tr>

                <td colspan="8"
                    class="text-center">

                    Nenhum cliente encontrado.

                </td>

            </tr>

        @endif
