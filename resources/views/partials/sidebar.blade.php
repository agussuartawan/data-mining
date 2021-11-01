<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sales-menu" aria-expanded="true"
            aria-controls="collapseBootstrap">
            <i class="fas fa-shopping-cart fa-fw"></i>
            <span>Penjualan</span>
        </a>
        <div id="sales-menu"
            class="collapse{{ request()->is('transaction/*') || request()->is('transaction') ? ' show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item{{ request()->is('transaction/data/*') || request()->is('transaction/filelist') ? ' active' : '' }}"
                    href="{{ route('transaction.data', 'latest') }}">Data penjualan</a>
                <a class="collapse-item{{ request()->is('transaction/create') ? ' active' : '' }}"
                    href="{{ route('transaction.create') }}">Import Penjualan</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider mb-0">
    <li class="nav-item{{ request()->is('bundle/*') || request()->is('bundle') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bundle-menu" aria-expanded="true"
            aria-controls="collapseBootstrap">
            <i class="fas fa-glass-martini-alt fa-fw"></i>
            <span>Produk Bundel</span>
        </a>
        <div id="bundle-menu"
            class="collapse{{ request()->is('bundle/*') || request()->is('bundle') ? ' show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item{{ request()->is('bundle/index') ? ' active' : '' }}"
                    href="{{ route('bundle.index') }}">Hasil Produk Bundel</a>
                <a class="collapse-item{{ request()->is('bundle/create') ? ' active' : '' }}"
                    href="{{ route('bundle.create') }}">Proses Produk Bundel</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider mb-0">
    <li class="nav-item{{ request()->is('user/*') || request()->is('user') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#user-menu" aria-expanded="true"
            aria-controls="collapseBootstrap">
            <i class="fas fa-users fa-fw"></i>
            <span>User</span>
        </a>
        <div id="user-menu" class="collapse{{ request()->is('user/*') || request()->is('user') ? ' show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item{{ request()->is('user/index') ? ' active' : '' }}"
                    href="{{ route('user.index') }}">Data User</a>
                <a class="collapse-item{{ request()->is('user/create') ? ' active' : '' }}"
                    href="{{ route('user.create') }}">Tambah User</a>
            </div>
        </div>
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
