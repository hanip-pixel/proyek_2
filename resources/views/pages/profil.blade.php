<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="{{ asset('css/profil.css') }}">
</head>
<body>

    @include('layouts.header')

    <div class="alert-notification-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-notification">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-notification">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <section class="hero">
        <div class="side-bar">
            <div class="elemen-profil">
                <div class="profil">
                    <img src="{{ $profil_pengguna && $profil_pengguna->foto ? asset('storage/foto_profil/' . $profil_pengguna->foto) : asset('images/profil.jpg') }}" alt="" class="foto-bulat">
                    <td class="isi"><h3>{{ $profil_pengguna->nama ?? '-' }}</h3></td>
                </div>
                <hr>
                <div class="riwayat-logout">
                    <div class="riwayat-button" style="cursor:pointer;" onclick="window.location.href='{{ route('riwayat.index') }}'">
                        <h3>Riwayat Pembelian</h3>
                    </div>
                    <div class="logout" onclick="logout()">
                        <h5>Log Out</h5>
                        <i class="bi bi-box-arrow-right"></i>
                    </div>
                </div>
                <hr>
                <div class="alamat">
                    <table class="tabel">
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td class="isi">{{ $profil_pengguna->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td class="isi">{{ $profil_pengguna->kelamin ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td class="isi">{{ $profil_pengguna->tanggal_lahir ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td class="isi">{{ $email }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>:</td>
                            <td class="isi">{{ $profil_pengguna->telepon ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-bio">
                <div class="biodata">
                    <div class="button">
                        <a href="#" id="btn-biodata" class="nav-button active"><h2>Biodata</h2></a>
                        <a href="#" id="btn-alamat" class="nav-button"><h3>Alamat</h3></a>
                    </div>
                    <hr>
                    <div class="profil-2" id="profilContent">
                        <!-- Konten akan di-load via AJAX -->
                        @include('pages.profil_biodata')
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function logout() {
            if(confirm('Apakah Anda yakin ingin keluar?')) {
                window.location.href = "{{ route('logout') }}";
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const profilContent = document.getElementById("profilContent");
            const btnBiodata = document.getElementById("btn-biodata");
            const btnAlamat = document.getElementById("btn-alamat");

            function setActive(buttonAktif) {
                [btnBiodata, btnAlamat].forEach(btn => {
                    btn.classList.remove("active");
                    btn.style.pointerEvents = "auto";
                });
                buttonAktif.classList.add("active");
                buttonAktif.style.pointerEvents = "none";
            }

            // Tombol alamat
            btnAlamat.addEventListener("click", function(e) {
                e.preventDefault();
                fetch("{{ route('profil.alamat') }}")
                    .then(response => response.text())
                    .then(data => {
                        profilContent.innerHTML = data;
                        setupEditButtons();
                        setActive(btnAlamat);
                    })
                    .catch(error => console.error("Gagal memuat konten:", error));
            });

            // Tombol biodata
            btnBiodata.addEventListener("click", function(e) {
                e.preventDefault();
                fetch("{{ route('profil.biodata') }}")
                    .then(response => response.text())
                    .then(data => {
                        profilContent.innerHTML = data;
                        setupEditButtons();
                        setActive(btnBiodata);
                    })
                    .catch(error => console.error("Gagal memuat biodata:", error));
            });

            // Set default aktif ke biodata
            setActive(btnBiodata);
        });

        function setupEditButtons() {
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const td = this.closest('td');
                    td.querySelector('.text').classList.add('d-none');
                    td.querySelector('.edit-input').classList.remove('d-none');

                    if (this.dataset.field === 'kelamin') {
                        const firstRadio = td.querySelector('input[type="radio"]');
                        if (firstRadio) firstRadio.focus();
                    }
                });
            });
        }

        // Auto close notification
        document.addEventListener("DOMContentLoaded", function() {
            const alerts = document.querySelectorAll('.alert-notification');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

</body>
</html>