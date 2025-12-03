<div class="profil-2" id="profilContent">
    <div class="box-foto">
        <div class="foto">
            <img src="{{ $profil_pengguna && $profil_pengguna->foto ? asset('storage/foto_profil/' . $profil_pengguna->foto) : asset('images/profil.jpg') }}" alt="" class="foto-ptofile" id="preview-foto">
        </div>
        <form action="{{ route('profil.uploadFoto') }}" method="post" enctype="multipart/form-data" class="upload-form">
            @csrf
            {{-- Tambahkan input hidden untuk username --}}
            @if(isset($profil_pengguna->username))
                <input type="hidden" name="username" value="{{ $profil_pengguna->username }}">
            @else
                <input type="hidden" name="username" value="{{ $username }}">
            @endif
            <label for="foto-upload" class="upload-label">
                <h4>Pilih Foto</h4>
            </label>
            <input type="file" name="foto" id="foto-upload" class="form-control d-none">

            <div class="upload-section mt-2">
                <button type="submit" class="btn btn-success upload">Upload Foto</button>
                <p class="form-text mt-1">Besar file maksimum 5MB dan ekstensi file yang diperbolehkan hanya JPG, PNG, JPEG</p>
            </div>
        </form>
    </div>
    <div class="isi-biodata">
        <form method="post" action="{{ route('profil.simpanBiodata') }}" id="biodataForm">
            @csrf
            {{-- PERBAIKAN: Gunakan username bukan id --}}
            @if(isset($profil_pengguna->username))
                <input type="hidden" name="username" value="{{ $profil_pengguna->username }}">
            @else
                <input type="hidden" name="username" value="{{ $username }}">
            @endif
            
            <div class="isi-data">
                <h3>Ubah Biodata</h3>
                <table class="tabel-biodata">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>
                            <span class="text">{{ $profil_pengguna->nama ?? '-' }}</span>
                            <input type="text" name="nama" class="form-control edit-input d-none" value="{{ $profil_pengguna->nama ?? '' }}">
                            <i class="bi bi-pencil-square edit-btn" data-field="nama"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td>
                            <span class="text">{{ $profil_pengguna->tanggal_lahir ?? '-' }}</span>
                            <input type="date" name="tanggal_lahir" class="form-control edit-input d-none" value="{{ $profil_pengguna->tanggal_lahir ?? '' }}">
                            <i class="bi bi-pencil-square edit-btn" data-field="tanggal_lahir"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>
                            <span class="text">{{ $profil_pengguna->kelamin ?? '-' }}</span>
                            <div class="edit-input d-none">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kelamin" id="laki" value="Laki-laki"
                                        {{ (isset($profil_pengguna->kelamin) && $profil_pengguna->kelamin == 'Laki-laki') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="laki">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kelamin" id="perempuan" value="Perempuan"
                                        {{ (isset($profil_pengguna->kelamin) && $profil_pengguna->kelamin == 'Perempuan') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                            <i class="bi bi-pencil-square edit-btn" data-field="kelamin"></i>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="isi-data-2">
                <h3>Ubah Kontak</h3>
                <table class="tabel-biodata">
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>
                            <span class="text">{{ $profil_pengguna->email ?? $email }}</span>
                            <input type="text" name="email" class="form-control edit-input d-none"
                                value="{{ $profil_pengguna->email ?? $email }}" readonly>
                            <i class="bi bi-pencil-square edit-btn" data-field="email" style="display:none;"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>:</td>
                        <td>
                            <span class="text">{{ $profil_pengguna->telepon ?? '-' }}</span>
                            <input type="text" name="telepon" class="form-control edit-input d-none" value="{{ $profil_pengguna->telepon ?? '' }}">
                            <i class="bi bi-pencil-square edit-btn" data-field="telepon"></i>
                        </td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-success mt-3">Simpan Biodata</button>
            </div>
        </form>
    </div>
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
            
            // Auto focus untuk input text
            if (inputField && (field === 'nama' || field === 'telepon')) {
                setTimeout(() => {
                    inputField.focus();
                }, 100);
            }
        });
    });

    // Preview foto sebelum upload
    const fotoUpload = document.getElementById('foto-upload');
    if (fotoUpload) {
        fotoUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewFoto = document.getElementById('preview-foto');
                    if (previewFoto) {
                        previewFoto.src = e.target.result;
                    }
                }
                reader.readAsDataURL(file);
            }
        });

        // Auto submit form ketika file dipilih
        fotoUpload.addEventListener('change', function() {
            if (this.files.length > 0) {
                this.closest('form').submit();
            }
        });
    }

    // Validasi form sebelum submit
    const biodataForm = document.getElementById('biodataForm');
    if (biodataForm) {
        biodataForm.addEventListener('submit', function(e) {
            // Debug: lihat data yang akan dikirim
            console.log('Data yang akan dikirim:');
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            // Cek apakah ada field yang sedang dalam mode edit
            const editInputs = this.querySelectorAll('.edit-input:not(.d-none)');
            if (editInputs.length === 0) {
                e.preventDefault();
                alert('Tidak ada perubahan data untuk disimpan. Klik ikon pensil untuk mengedit data.');
                return false;
            }
            
            // Validasi telepon
            const teleponInput = this.querySelector('input[name="telepon"]');
            if (teleponInput && !teleponInput.classList.contains('d-none')) {
                const teleponValue = teleponInput.value.trim();
                if (teleponValue && !/^[0-9+\-\s()]+$/.test(teleponValue)) {
                    e.preventDefault();
                    alert('Format nomor telepon tidak valid. Hanya boleh berisi angka, +, -, (, ) dan spasi.');
                    teleponInput.focus();
                    return false;
                }
            }
            
            // Validasi nama tidak boleh kosong jika di-edit
            const namaInput = this.querySelector('input[name="nama"]');
            if (namaInput && !namaInput.classList.contains('d-none') && !namaInput.value.trim()) {
                e.preventDefault();
                alert('Nama tidak boleh kosong.');
                namaInput.focus();
                return false;
            }
        });
    }
});
</script>