<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
        <a href="{{url('home')}}">
            <img src="assets/images/O.png" class="logo-icon" alt="logo icon">
            <h5 class="logo-text">ONEMAX</h5>
        </a>
    </div>
    <ul class="sidebar-menu do-nicescrol">
        <li class="sidebar-header">MAIN NAVIGATION</li>
        @can('Category_Index')
        <li class="">
            <a href="{{ url('categories') }}" data-active="true">
                <i class="zmdi zmdi-view-dashboard"></i> <span>Categorías</span>
            </a>
        </li>
        @endcan
        <li class="">
            <a href="{{ url('products') }}" data-active="false">
                <i class="zmdi zmdi-playstation"></i> <span>Productos</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('pos') }}" data-active="false">
                <i class="zmdi zmdi-format-list-bulleted"></i> <span>Ventas</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('roles') }}" data-active="false">
                <i class="zmdi zmdi-grid"></i> <span>Roles</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('permisos') }}" data-active="false">
                <i class="zmdi zmdi-calendar-check"></i> <span>Permisos</span>
                {{-- <small class="badge float-right badge-light">New</small> --}}
            </a>
        </li>

        <li class="">
            <a href="{{ url('asignar') }}" data-active="false">
                <i class="zmdi zmdi-mood"></i> <span>Asignar</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('users') }}" data-active="false">
                <i class="zmdi zmdi-accounts"></i> <span>Usuarios</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('coins') }}" data-active="false">
                <i class="zmdi zmdi-face"></i> <span>Monedas</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('cashout') }}" data-active="false">
                <i class="zmdi zmdi-attachment"></i> <span>Arqueos</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('reports') }}" data-active="false">
                <i class="zmdi zmdi-assignment"></i> <span>Reportes</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('services') }}" data-active="false">
                <i class="zmdi zmdi-collection-bookmark"></i> <span>Servicios/Planes</span>
            </a>
        </li>

        {{-- <li class="">
            <a href="{{ url('discounts') }}" data-active="false">
                <i class="zmdi zmdi-window-minimize"></i> <span>Descuentos de servicio</span>
            </a>
        </li> --}}

        <li class="">
            <a href="{{ url('locations') }}" data-active="false">
                <i class="zmdi zmdi-pin"></i> <span>Ubicación servicios</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('customers') }}" data-active="false">
                <i class="zmdi zmdi-male-female"></i> <span>Clientes</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('methods') }}" data-active="false">
                <i class="zmdi zmdi-layers"></i> <span>Metodos de pago</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('payments') }}" data-active="false">
                <i class="zmdi zmdi-money"></i> <span>Pagos de servicios</span>
            </a>
        </li>
    </ul>

</div>
