<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-cocktail fa-2x"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Trisno App</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Transaksi
    </div>
    <li class="nav-item{{ request()->is('transaction/*') || request()->is('transaction') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sales-menu" aria-expanded="true"
            aria-controls="collapseBootstrap">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Penjualan</span>
        </a>
        <div id="sales-menu" class="collapse{{ request()->is('transaction/*') || request()->is('sales') ? ' show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item{{ request()->is('sales') ? ' active' : '' }}"
                    href="{{ route('transaction.index') }}">Data penjualan</a>
                <a class="collapse-item{{ request()->is('transaction/create') ? ' active' : '' }}"
                    href="{{ route('transaction.create') }}">Import Penjualan</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Pendukung Keputusan
    </div>
    <li class="nav-item{{ request()->is('bundle/*') || request()->is('bundle') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#recommendation-menu"
            aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
            <span>Produk Bundel</span>
        </a>
        <div id="recommendation-menu"
            class="collapse{{ request()->is('bundle/*') || request()->is('bundle') ? ' show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item{{ request()->is('bundle/index') ? ' active' : '' }}"
                    href="{{ route('bundle.index') }}">Hasil Produk Bundel</a>
                <a class="collapse-item{{ request()->is('bundle') ? ' active' : '' }}"
                    href="{{ route('bundle.create') }}">Proses Produk Bundel</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Manajemen User
    </div>
    <li class="nav-item{{ request()->is('bundle/*') || request()->is('bundle') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#recommendation-menu"
            aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
            <span>User</span>
        </a>
        <div id="recommendation-menu"
            class="collapse{{ request()->is('bundle/*') || request()->is('bundle') ? ' show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item{{ request()->is('bundle/index') ? ' active' : '' }}"
                    href="{{ route('bundle.index') }}">Data User</a>
                <a class="collapse-item{{ request()->is('bundle') ? ' active' : '' }}"
                    href="{{ route('bundle.create') }}">Tambah User</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider mb-0">
    <li class="nav-item">
        <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>
</ul>
