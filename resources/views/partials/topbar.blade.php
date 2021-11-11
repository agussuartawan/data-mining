<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @if (auth()->user()->avatar)
                    <img class="img-profile rounded-circle border-0" src="{{ asset('') }}/avatar/{{ auth()->user()->avatar }}"
                    style="max-width: 60px">                         
                @else
                    <img class="img-profile rounded-circle border-0" src="https://ui-avatars.com/api/?background=ff1493&color=fff&size=128&rounded=true&name={{ auth()->user()->name }}"
                    style="max-width: 60px">
                @endif
                <span class="ml-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('user.profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
            </div>
        </li>
    </ul>
</nav>
