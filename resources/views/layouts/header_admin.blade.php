<div class="container-fluid">
    <div class="row">
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="min-height: 100vh; width:210px">
            <div class="position-fixed pt-3">
                <ul class="nav flex-column">
                    <li>
                        <div class="logo"><img src="{{ asset('images/logo.png') }}" alt=""><p>Warung Tita</p></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/admin/dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/admin/pesanan') }}">
                            <i class="bi bi-cart me-2"></i>Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/admin/pengguna') }}">
                            <i class="bi bi-people me-2"></i>Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/admin/produk') }}">
                            <i class="bi bi-box-seam me-2"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <form method="POST" action="{{ url('/admin/logout') }}">
                            @csrf
                            <button type="submit" class="nav-link text-white btn btn-link p-0" style="border: none; background: none; text-align: left; width: 100%;">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">