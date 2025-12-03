<header class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-white">@yield('title', 'Dashboard')</h1>
    <div class="text-white">
        <i class="bi bi-person-circle me-2"></i>
        {{ Auth::guard('admin')->user()->username }}
    </div>
</header>