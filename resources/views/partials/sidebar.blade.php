<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon">
        <i class="fas fa-cocktail"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Trisno App</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
      <a class="nav-link" href="index.html">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Data Master
    </div>
    <li class="nav-item">
      <a class="nav-link" href="{{route('product.index')}}">
        <i class="fas fa-fw fa-glass-martini-alt"></i>
        <span>Produk</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="charts.html">
        <i class="fas fa-fw fa-users"></i>
        <span>Pelanggan</span>
      </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Transaksi
    </div>
    <li class="nav-item">
      <a class="nav-link" href="charts.html">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Penjualan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="charts.html">
        <i class="fas fa-fw fa-cart-arrow-down"></i>
        <span>Pembelian</span>
      </a>
    </li>
    <hr class="sidebar-divider mb-0">
    <li class="nav-item">
      <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span>
      </a>
    </li>
  </ul>