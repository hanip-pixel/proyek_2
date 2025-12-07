@extends('admin.layouts.app')

@section('title', 'Manajemen Ulasan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-white">Manajemen Ulasan</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card glass-card">
    <div class="card-body">
        @if($ulasan->isEmpty())
            <div class="text-center py-4">
                <i class="bi bi-chat-text fs-1 text-muted"></i>
                <p class="text-muted mt-2">Belum ada ulasan</p>
            </div>
        @else
            @foreach($ulasan as $item)
            <div class="ulasan-item mb-4 p-3 rounded" style="background: rgba(255,255,255,0.05);">
                <!-- Header Ulasan -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h5 class="text-white mb-1">{{ $item->nama }}</h5>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rating text-warning">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $item->rating)
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                                <span class="text-white-50 ms-2">{{ $item->rating }}/5</span>
                            </div>
                            <span class="text-white-50">{{ $item->produk_nama }}</span>
                            <span class="text-white-50">•</span>
                            <span class="text-white-50">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light" type="button" 
                                data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item text-danger" href="#" 
                                   onclick="confirmDelete({{ $item->id }})">
                                    <i class="bi bi-trash me-2"></i> Hapus Ulasan
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Komentar Ulasan -->
                <div class="mb-3">
                    <p class="text-white mb-0">{{ nl2br(e($item->komentar)) }}</p>
                </div>

                <!-- Balasan Admin (Jika Ada) -->
                @if($item->balasan_pesan)
                <div class="balasan-admin ps-4 border-start border-primary">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="text-primary mb-0">
                                <i class="bi bi-shield-check"></i> Admin
                            </h6>
                            <small class="text-white-50">
                                {{ \Carbon\Carbon::parse($item->balasan_tanggal)->format('d M Y H:i') }}
                            </small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger" 
                                onclick="confirmDeleteBalasan({{ $item->balasan_id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <p class="text-white mb-0">{{ nl2br(e($item->balasan_pesan)) }}</p>
                </div>
                @endif

                <!-- Form Balasan -->
                <div class="mt-3">
                    <form method="POST" action="{{ route('admin.ulasan.balasan.store', $item->id) }}">
                        @csrf
                        <div class="mb-2">
                            <textarea name="pesan" class="form-control" rows="3" 
                                      placeholder="Ketik balasan untuk ulasan ini..." required>{{ old('pesan', $item->balasan_pesan ?? '') }}</textarea>
                            <small class="text-white-50">Balasan akan ditampilkan di halaman produk</small>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm">
                                @if($item->balasan_pesan)
                                    <i class="bi bi-arrow-clockwise"></i> Perbarui Balasan
                                @else
                                    <i class="bi bi-send"></i> Kirim Balasan
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Delete Forms -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="deleteBalasanForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    function confirmDelete(ulasanId) {
        if (confirm('Apakah Anda yakin ingin menghapus ulasan ini?')) {
            const form = document.getElementById('deleteForm');
            form.action = '{{ url("admin/ulasan") }}/' + ulasanId;
            form.submit();
        }
    }

    function confirmDeleteBalasan(balasanId) {
        if (confirm('Apakah Anda yakin ingin menghapus balasan ini?')) {
            const form = document.getElementById('deleteBalasanForm');
            form.action = '{{ url("admin/ulasan/balasan") }}/' + balasanId;
            form.submit();
        }
    }

    // Auto-resize textarea
    document.querySelectorAll('textarea[name="pesan"]').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        // Trigger once on load
        textarea.dispatchEvent(new Event('input'));
    });
</script>
@endpush
@endsection