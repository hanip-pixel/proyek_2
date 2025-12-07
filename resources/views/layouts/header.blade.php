<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand"><img src="{{ asset('images/logo.png') }}" alt="Logo" /></a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/about') }}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/riwayat') }}">Riwayat</a>
                </li>
            </ul>
            {{-- resources/views/layouts/header.blade.php --}}
            <form class="d-flex search-form ms-auto" action="{{ url('/search') }}" method="GET">
                <input
                    class="form-control me-2 search-input"
                    type="search"
                    name="query"
                    placeholder="Pencarian"
                    aria-label="Search"
                    required
                />
                <button class="btn btn-outline-success search-button" type="submit">
                    Cari
                </button>
            </form>
            <div class="icon">
                {{-- ✅ GUNAKAN SESSION CUSTOM ANDA --}}
                <a href="{{ Session::get('loggedin') ? url('/profil') : url('/login') }}"><i class="bi bi-person-circle"></i></a>
                
                @if(Session::get('loggedin'))
                    {{-- ✅ KERANJANG HANYA UNTUK YANG SUDAH LOGIN --}}
                    <a href="{{ url('/keranjang') }}"><i class="bi bi-cart3"></i><span id="cart-counter">{{ count(Session::get('keranjang', [])) }}</span></a>
                @else
                    {{-- ✅ JIKA BELUM LOGIN, REDIRECT KE LOGIN --}}
                    <a href="{{ url('/login') }}"><i class="bi bi-cart3"></i></a>
                @endif
            </div>
            <div class="login">
                @if(Session::get('loggedin'))
                    <form method="POST" action="{{ url('/logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link p-0" style="text-decoration: none; border: none; background: none; color: inherit;">Sign Out</button>
                    </form>
                @else
                    <a href="{{ url('/login') }}">Sign In</a>
                @endif
            </div>
        </div>
    </div>
</nav>