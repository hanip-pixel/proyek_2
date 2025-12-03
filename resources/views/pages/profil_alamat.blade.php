<div class="profil-2">
    <div class="box-foto-2">
        <div class="foto-2">
            <img src="{{ asset('images/world.png') }}" alt="" class="foto-profil">
        </div>
    </div>
    <form method="post" action="{{ route('profil.simpanAlamat') }}">
        @csrf
        {{-- Tambahkan input hidden untuk username --}}
        @if(isset($profil_pengguna->username))
            <input type="hidden" name="username" value="{{ $profil_pengguna->username }}">
        @else
            <input type="hidden" name="username" value="{{ $username }}">
        @endif
        @if(isset($profil_pengguna->id))
            <input type="hidden" name="id" value="{{ $profil_pengguna->id }}">
        @endif
        <div class="isi-biodata">
            <div class="isi-data">
                <h3>Ubah Alamat</h3>
                <table class="tabel-biodata">
                    <tr>
                        <td>Kabupaten</td>
                        <td>:</td>
                        <td>
                            <span class="text">{{ $profil_pengguna->kabupaten ?? '-' }}</span>
                            <input type="text" name="kabupaten" class="form-control edit-input d-none" value="{{ $profil_pengguna->kabupaten ?? '' }}">
                            <i class="bi bi-pencil-square edit-btn" data-field="kabupaten"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>Kecamatan</td>
                        <td>:</td>
                        <td>
                            <span class="text">{{ $profil_pengguna->kecamatan ?? '-' }}</span>
                            <input type="text" name="kecamatan" class="form-control edit-input d-none" value="{{ $profil_pengguna->kecamatan ?? '' }}">
                            <i class="bi bi-pencil-square edit-btn" data-field="kecamatan"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>Desa</td>
                        <td>:</td>
                        <td>
                            <span class="text">{{ $profil_pengguna->desa ?? '-' }}</span>
                            <input type="text" name="desa" class="form-control edit-input d-none" value="{{ $profil_pengguna->desa ?? '' }}">
                            <i class="bi bi-pencil-square edit-btn" data-field="desa"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>Rt/Rw</td>
                        <td>:</td>
                        <td>
                            <span class="text">{{ $profil_pengguna->rt_rw ?? '-' }}</span>
                            <input type="number" name="rt_rw" class="form-control edit-input d-none" value="{{ $profil_pengguna->rt_rw ?? '' }}">
                            <i class="bi bi-pencil-square edit-btn" data-field="rt_rw"></i>
                        </td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-success mt-3">Simpan</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk toggle edit mode
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const field = this.getAttribute('data-field');
            const row = this.closest('tr');
            const textSpan = row.querySelector('.text');
            const inputField = row.querySelector('.edit-input');
            
            // Sembunyikan text, tampilkan input
            if (textSpan) textSpan.classList.add('d-none');
            if (inputField) inputField.classList.remove('d-none');
            this.style.display = 'none';
        });
    });

    // Validasi form sebelum submit
    const alamatForm = document.querySelector('form[action="{{ route('profil.simpanAlamat') }}"]');
    if (alamatForm) {
        alamatForm.addEventListener('submit', function(e) {
            // Cek apakah ada field yang sedang dalam mode edit
            const editInputs = this.querySelectorAll('.edit-input:not(.d-none)');
            if (editInputs.length === 0) {
                e.preventDefault();
                alert('Tidak ada perubahan data untuk disimpan. Klik ikon pensil untuk mengedit data.');
                return false;
            }
            
            // Validasi RT/RW
            const rtRwInput = this.querySelector('input[name="rt_rw"]');
            if (rtRwInput && !rtRwInput.classList.contains('d-none')) {
                const rtRwValue = rtRwInput.value.trim();
                if (rtRwValue) {
                    // Validasi format RT/RW (contoh: 001/002 atau 1/2)
                    if (!/^\d{1,3}\/\d{1,3}$/.test(rtRwValue)) {
                        e.preventDefault();
                        alert('Format RT/RW tidak valid. Gunakan format: angka/angka (contoh: 001/002 atau 1/2)');
                        rtRwInput.focus();
                        return false;
                    }
                    
                    // Validasi angka tidak boleh 0
                    const parts = rtRwValue.split('/');
                    if (parts[0] === '0' || parts[1] === '0') {
                        e.preventDefault();
                        alert('RT dan RW tidak boleh 0.');
                        rtRwInput.focus();
                        return false;
                    }
                }
            }
            
            // Validasi field alamat lainnya
            const kabupatenInput = this.querySelector('input[name="kabupaten"]');
            const kecamatanInput = this.querySelector('input[name="kecamatan"]');
            const desaInput = this.querySelector('input[name="desa"]');
            
            // Jika salah satu field alamat diisi, pastikan yang lain juga diisi untuk konsistensi
            const filledFields = [
                kabupatenInput && !kabupatenInput.classList.contains('d-none') && kabupatenInput.value.trim() ? 'kabupaten' : null,
                kecamatanInput && !kecamatanInput.classList.contains('d-none') && kecamatanInput.value.trim() ? 'kecamatan' : null,
                desaInput && !desaInput.classList.contains('d-none') && desaInput.value.trim() ? 'desa' : null
            ].filter(Boolean);
            
            if (filledFields.length > 0 && filledFields.length < 3) {
                e.preventDefault();
                alert('Untuk konsistensi data, harap lengkapi semua field alamat (Kabupaten, Kecamatan, dan Desa).');
                return false;
            }
            
            // Validasi karakter khusus untuk field teks
            const textFields = [kabupatenInput, kecamatanInput, desaInput];
            const invalidChars = /[<>$#@!*%^&()+=?/\\|[\]{};:`~]/;
            
            for (let field of textFields) {
                if (field && !field.classList.contains('d-none') && field.value.trim()) {
                    if (invalidChars.test(field.value)) {
                        e.preventDefault();
                        alert(`Field ${field.name} mengandung karakter yang tidak diizinkan.`);
                        field.focus();
                        return false;
                    }
                }
            }
        });
    }
    
    // Auto focus ke input field ketika masuk mode edit
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-btn')) {
            const field = e.target.getAttribute('data-field');
            const inputField = e.target.closest('tr').querySelector('.edit-input');
            if (inputField && !inputField.classList.contains('d-none')) {
                // Beri sedikit delay untuk memastikan input sudah visible
                setTimeout(() => {
                    inputField.focus();
                }, 100);
            }
        }
    });
});
</script>