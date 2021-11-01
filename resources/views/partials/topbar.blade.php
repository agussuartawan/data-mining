<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">            
            <a class="nav-link" href="{{ route('transaction.create') }}" role="button"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-cloud-download-alt fa-2x" rel="tooltip" title="Import Transaksi"></i>
              </a>
        </li>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link" href="{{ route('bundle.create') }}" role="button"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-spinner fa-2x" rel="tooltip" title="Proses Produk Bundel"></i>
              </a>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="{{ asset('') }}img/logo-tmb.jpg"
                    style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">Pak Trisno</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
