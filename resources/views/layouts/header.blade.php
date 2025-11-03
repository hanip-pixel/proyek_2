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
                    <a class="nav-link" href="{{ url('/') }}" onclick="return handleNavClick(event)">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/tentang-kami') }}" onclick="return handleNavClick(event)">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/riwayat') }}" onclick="return handleNavClick(event)">Riwayat</a>
                </li>
            </ul>
            <form class="d-flex search-form ms-auto" action="{{ url('/search') }}" method="GET" onsubmit="return handleNavClick(event)">
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
                <a href="{{ auth()->check() ? url('/profil') : url('/login') }}" onclick="return handleNavClick(event)"><i class="bi bi-person-circle"></i></a>
                @if(auth()->check())
                    <a href="{{ url('/keranjang') }}" onclick="return handleNavClick(event)"><i class="bi bi-cart3"></i><span id="cart-counter">{{ session('keranjang_count', 0) }}</span></a>
                @else
                    <a href="{{ url('/login') }}" onclick="return handleNavClick(event)"><i class="bi bi-cart3"></i></a>
                @endif
            </div>
            <div class="login">
                @if(auth()->check())
                    <form method="POST" action="{{ url('/logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link p-0" style="text-decoration: none; border: none; background: none; color: inherit;">Sign Out</button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" onclick="return handleNavClick(event)">Sign In</a>
                @endif
            </div>
        </div>
    </div>
</nav>