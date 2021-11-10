<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-cocktail fa-2x"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Trisno App</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fas fa-tachometer-alt fa-fw"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider mb-0">
    <li class="nav-item{{ request()->is('transaction/*') || request()->is('transaction') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('transaction.data', 'latest') }}">
            <i class="fas fa-shopping-cart fa-fw"></i>
            <span>Penjualan</span>
        </a>
    </li>
    <hr class="sidebar-divider mb-0">
    <li class="nav-item{{ request()->is('bundle/*') || request()->is('bundle') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('bundle.index') }}">
            <i class="fas fa-glass-martini-alt fa-fw"></i>
            <span>Produk Bundel</span>
        </a>
    </li>
    <hr class="sidebar-divider mb-0">
    <li class="nav-item{{ request()->is('user/*') || request()->is('user') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('user.index') }}">
            <i class="fas fa-users fa-fw"></i>
            <span>User</span>
        </a>
    </li>
    <hr class="sidebar-divider mb-0">
    <li class="nav-item {{ request()->is('report') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('report') }}">
            <i class="fas fa-file-download fa-fw"></i>
            <span>Laporan</span></a>
    </li>
    <hr class="sidebar-divider mb-0">
    <li class="nav-item">
        <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-fw"></i>
            <span>Logout</span>
        </a>
    </li>
</ul>
