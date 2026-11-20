<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-mobile"></i>
        </div>
        <div class="sidebar-brand-text mx-3">GADGET STORE</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Halaman
    </div>

    <!-- Categories -->
    <li class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse"
            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-tags"></i>
            <span>Categories</span>
        </a>

        <div id="collapseTwo" class="collapse"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Halaman Kategori:</h6>
                <a class="collapse-item" href="{{ route('categories.index') }}">Data Kategori</a>
                <a class="collapse-item" href="{{ route('categories.create') }}">Tambah Kategori</a>
            </div>
        </div>
    </li>

    <!-- Produk -->
    <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse"
            data-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Produk</span>
        </a>

        <div id="collapseUtilities" class="collapse"
            aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Halaman Produk:</h6>
                <a class="collapse-item" href="{{ route('products.index') }}">Data Produk</a>
                <a class="collapse-item" href="{{ route('products.create') }}">Tambah Produk</a>
            </div>
        </div>
    </li>

    <!-- Laporan -->
    <li class="nav-item {{ request()->routeIs('reports.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reports.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->