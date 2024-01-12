<header class="topbar-nav">
    <nav class="navbar navbar-expand fixed-top">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                    <i class="icon-menu menu-icon"></i>
                </a>
            </li>
            <livewire:search-controller>
        </ul>

        <ul class="navbar-nav align-items-center right-nav-link">
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <span class="user-profile">
                        @if (Auth()->user()->image != null)
                            <img src="{{ asset('storage/users/' . Auth()->user()->image) }}" class="img-circle"
                                alt="user avatar">
                        @else
                            <img class="align-self-start mr-3" src="https://via.placeholder.com/110x110"
                                class="img-circle" alt="user avatar">
                        @endif
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item user-details">
                        <a href="javaScript:void();">
                            <div class="media">

                                <div class="media-body">
                                    <h6 class="mt-2 user-title">{{ Auth()->user()->name }}</h6>
                                    <p class="user-subtitle">{{ Auth()->user()->email }}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <a href="{{ url('profile') }}">
                        <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Cuenta</li>
                    </a>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-divider"></li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>
    </nav>
</header>
