<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">


    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif



    {{-- Sidebar menu --}}
<div class="sidebar">

    {{-- MENU --}}
    <div class="sidebar-menu-area">


        <nav class="pt-2">


            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview"
                role="menu">


                @each('adminlte::partials.sidebar.menu-item',
                $adminlte->menu('sidebar'),
                'item')


            </ul>


        </nav>






    {{-- RODAPÉ --}}
    <div class="sidebar-footer">


        <div class="sidebar-user">


            <div class="sidebar-user-avatar">

                {{ strtoupper(substr(Auth::user()->name ?? 'S',0,1)) }}

            </div>



            <div class="sidebar-user-info">

                <strong>
                    {{ Auth::user()->name ?? 'Usuário' }}
                </strong>


                <small>
                    Administrador
                </small>

            </div>


        </div>



        <div class="sidebar-status">

            <span class="status-dot"></span>

            Sistema Online

        </div>



        <form method="POST" action="{{ route('logout') }}">

            @csrf


            <button type="submit" class="sidebar-logout">

                <i class="fas fa-sign-out-alt mr-2"></i>

                Sair

            </button>


        </form>



    </div>


</div>


</aside>
