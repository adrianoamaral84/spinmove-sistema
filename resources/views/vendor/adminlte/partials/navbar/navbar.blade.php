@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- NOTIFICAÇÕES --}}
<li class="nav-item dropdown">

    <a
    class="nav-link"

    data-toggle="dropdown"

    href="#">

        <i class="far fa-bell" id="btnNotif"></i>

        @if(($topCount ?? 0) > 0)

        <span class="
        badge
        badge-danger
        navbar-badge">

            {{ $topCount }}

        </span>

        @endif

    </a>


    <div class="
    dropdown-menu

    dropdown-menu-lg

    dropdown-menu-right">

        <span class="
        dropdown-item
        dropdown-header">

            {{ $topCount ?? 0 }}

            Notificações

        </span>


        @forelse(
            $topNotifications ?? []
            as $item
        )

        <div class="
        dropdown-divider">

        </div>

        <a
href="#"

onclick="marcarNotif({{ $item->id }}, this)"

class="dropdown-item">


            <i class="
            fas fa-user
            mr-2">

            </i>

            <strong>

            {{ $item->titulo }}

            </strong>

            <br>

            Nome:
            {{ $item->nome_cliente }}

            <br>

            Tel:
            {{ $item->telefone }}

            <br>

            Plano:
            {{ $item->plano->nome ?? '-' }}

            <br>
<small class="text-muted">

{{ $item->created_at
->diffForHumans() }}

</small>
        </a>

        @empty

        <a href="#"
        class="
        dropdown-item">

            Sem notificações

        </a>

        @endforelse

    </div>

</li>



{{-- User menu link --}}
@if(Auth::user())

    @if(
    config(
    'adminlte.usermenu_enabled'
    )
    )

        @include(
        'adminlte::partials.navbar.menu-item-dropdown-user-menu'
        )

    @else

        @include(
        'adminlte::partials.navbar.menu-item-logout-link'
        )

    @endif

@endif

        {{-- Right sidebar toggler link --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>
<script>

function marcarNotif(id, elemento){

event.preventDefault();

fetch(

`/notificacoes/${id}/lida`,

{

method:'POST',

headers:{

'X-CSRF-TOKEN':
'{{ csrf_token() }}'

}

})

.then(()=>{

elemento.style.opacity='0.5';

let badge =

document.querySelector(
'.navbar-badge'
);

if(badge){

let valor =
parseInt(
badge.innerText
);

valor--;

if(valor<=0){

badge.remove();

}else{

badge.innerText=
valor;

}

}

});

}

</script>
</nav>


