<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
        <a href="{{url('home')}}">
            <img src="assets/images/O.png" class="logo-icon" alt="logo icon">
            <h5 class="logo-text">SIGECOMOON</h5>
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
                <small class="badge float-right badge-light">New</small>
            </a>
        </li>

        <li class="">
            <a href="{{ url('asignar') }}" data-active="false">
                <i class="zmdi zmdi-mood"></i> <span>Asignar</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('users') }}" data-active="false">
                <i class="zmdi zmdi-account"></i> <span>Usuarios</span>
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
                <i class="zmdi zmdi-assignment"></i> <span>Servicios/Planes</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('discounts') }}" data-active="false">
                <i class="zmdi zmdi-assignment"></i> <span>Descuentos de servicio</span>
            </a>
        </li>

        <li class="">
            <a href="{{ url('customers') }}" data-active="false">
                <i class="zmdi zmdi-assignment"></i> <span>Clientes</span>
            </a>
        </li>

        <li class="">
            <a href="#" target="_blank" data-active="false">
                <i class="zmdi zmdi-lock"></i> <span>Login</span>
            </a>
        </li>

        <li class="">
            <a href="#" target="_blank">
                <i class="zmdi zmdi-account-circle"></i> <span>Registration</span>
            </a>
        </li>

        <li class="sidebar-header">LABELS</li>
        <li><a href="javaScript:void();"><i class="zmdi zmdi-coffee text-danger"></i> <span>Important</span></a></li>
        <li><a href="javaScript:void();"><i class="zmdi zmdi-chart-donut text-success"></i> <span>Warning</span></a>
        </li>
        <li><a href="javaScript:void();"><i class="zmdi zmdi-share text-info"></i> <span>Information</span></a></li>

    </ul>

</div>
