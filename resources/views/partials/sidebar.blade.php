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
        Data Master
    </div>
    <li class="nav-item{{ request()->is('product/*') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#product-menu" aria-expanded="true"
            aria-controls="collapseBootstrap">
            <i class="fas fa-fw fa-glass-martini-alt"></i>
            <span>Produk</span>
        </a>
        <div id="product-menu" class="collapse {{ request()->is('product/*') ? 'show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('product/group') ? 'active' : '' }}"
                    href="{{ route('group.index') }}">Data group</a>
                <a class="collapse-item {{ request()->is('product/index/0') ? 'active' : '' }}"
                    href="{{ route('product.index', 0) }}">Data Produk</a>
                <a class="collapse-item {{ request()->is('product/create') ? 'active' : '' }}"
                    href="{{ route('product.create') }}">Produk baru</a>
                <a class="collapse-item {{ request()->is('product/create/bundle') ? 'active' : '' }}"
                    href="{{ route('product.create.bundle') }}">Produk bundel baru</a>
            </div>
        </div>
    </li>
    <li class="nav-item{{ request()->is('customer/*') || request()->is('customer') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#customer-menu" aria-expanded="true"
            aria-controls="collapseBootstrap">
            <i class="fas fa-fw fa-users"></i>
            <span>Pelanggan</span>
        </a>
        <div id="customer-menu"
            class="collapse{{ request()->is('customer/*') || request()->is('customer') ? ' show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item{{ request()->is('customer') ? ' active' : '' }}"
                    href="{{ route('customer.index') }}">Data pelanggan</a>
                <a class="collapse-item{{ request()->is('customer/create') ? ' active' : '' }}"
                    href="{{ route('customer.create') }}">Pelanggan baru</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Transaksi
    </div>
    <li class="nav-item{{ request()->is('sales/*') || request()->is('sales') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sales-menu" aria-expanded="true"
            aria-controls="collapseBootstrap">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Penjualan</span>
        </a>
        <div id="sales-menu" class="collapse{{ request()->is('sales/*') || request()->is('sales') ? ' show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item{{ request()->is('sales') ? ' active' : '' }}"
                    href="{{ route('sales.index') }}">Data penjualan</a>
                <a class="collapse-item{{ request()->is('sales/create') ? ' active' : '' }}"
                    href="{{ route('sales.create') }}">Penjualan baru</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Pendukung Keputusan
    </div>
    <li class="nav-item{{ request()->is('recommendation/*') || request()->is('recommendation') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#recommendation-menu"
            aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
            <span>Rekomendasi</span>
        </a>
        <div id="recommendation-menu"
            class="collapse{{ request()->is('recommendation/*') || request()->is('recommendation') ? ' show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item{{ request()->is('recommendation/create') ? ' active' : '' }}"
                    href="{{ route('recommendation.create') }}">Data rekomendasi</a>
                <a class="collapse-item{{ request()->is('recommendation') ? ' active' : '' }}"
                    href="{{ route('recommendation.index') }}">Proses rekomendasi</a>
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
