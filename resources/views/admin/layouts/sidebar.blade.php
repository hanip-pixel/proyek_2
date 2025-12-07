<div class="d-flex flex-column">
    <div class="logo p-3 text-center border-bottom">
        <!-- Logo dari folder public/images/ -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="40" height="40" class="mb-2">
        <h5 class="text-white mb-0">Admin Panel</h5>
    </div>
    
    <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
           href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
           href="{{ route('admin.products.index') }}">
            <i class="bi bi-box me-2"></i> Manajemen Produk
        </a>
        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
           href="{{ route('admin.orders.index') }}">
            <i class="bi bi-cart me-2"></i> Manajemen Pesanan
        </a>
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
           href="{{ route('admin.users.index') }}">
            <i class="bi bi-people me-2"></i> Manajemen Pengguna
        </a>
        <a class="nav-link {{ request()->routeIs('admin.ulasan.*') ? 'active' : '' }}" 
            href="{{ route('admin.ulasan.index') }}">
            <i class="bi bi-chat-text me-2"></i> Manajemen Ulasan
        </a>        
        <form action="{{ route('admin.logout') }}" method="POST" class="nav-link">
            @csrf
            <button type="submit" class="btn btn-link text-white p-0 border-0 text-start w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </nav>
</div>