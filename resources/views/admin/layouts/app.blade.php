<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* RESET CSS UNTUK MODAL BOOTSTRAP */
        :root {
            --background: #013023;
            --button: #084908;
            --button2: #32de32;
            --hover-button: #00695c;
            --color-text: #817e7e;
            --text-2: #444444;
            --white: #ffffff;
        }

        /* BACKGROUND - PASTIKAN DI BAWAH SEMUA */
        body {
            background-color: #333;
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('images/background.jpg') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            z-index: -1; /* BAWAH, tapi bukan negatif */
            filter: brightness(80%) blur(3px) grayscale(20%);
        }

        /* SIDEBAR DAN CONTENT - Z-INDEX NORMAL */
        .sidebar {
            background-color: var(--text-2);
            min-height: 100vh;
            padding: 0;
            position: relative;
            z-index: 1; /* NORMAL */
        }

        .sidebar .nav-link {
            color: var(--white);
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            position: relative;
            min-height: 100vh;
            padding: 20px;
            z-index: 1; /* NORMAL */
        }

        /* ===== FIX CRITICAL UNTUK MODAL BOOTSTRAP ===== */
        /* HAPUS SEMUA OVERRIDE Z-INDEX DARI MODAL */
        .modal {
            /* Biarkan Bootstrap mengatur z-index */
        }
        
        .modal-backdrop {
            /* Biarkan Bootstrap mengatur z-index */
        }
        
        /* PASTIKAN MODAL BACKDROP BISA DIKLIK */
        .modal-backdrop.show {
            opacity: 0.5 !important;
            pointer-events: auto !important;
        }
        
        /* CARD STYLING */
        .my-custom-card-primary {
            background-color: var(--hover-button);
        }

        .my-custom-card-success {
            background-color: #98c319;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
        }
        
        /* FIX UNTUK ELEMEN YANG MENUTUPI BACKDROP */
        .sidebar,
        .main-content,
        .container-fluid,
        .row,
        .col-md-3,
        .col-md-9 {
            position: relative !important;
            z-index: auto !important;
        }
        
        /* PASTIKAN MODAL BISA DI-CLOSE */
        .btn-close {
            position: relative;
            z-index: 9999;
        }

        .sidebar .btn-link {
            text-decoration: none !important;
        }

        /* Atau lebih spesifik: */
        .sidebar form .btn-link {
            text-decoration: none !important;
        }
    </style>
</head>
<body>
    <!-- HAPUS SEMUA Z-INDEX DARI CONTAINER -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                @include('admin.layouts.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                @include('admin.layouts.header')
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- MODAL AKAN DITAMPILKAN DI SECTION MODALS -->
    @yield('modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- FIX SCRIPT UNTUK MODAL -->
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing modal fixes...');
            
            // 1. Fix untuk backdrop click
            document.addEventListener('click', function(e) {
                // Jika klik pada backdrop
                if (e.target.classList.contains('modal-backdrop')) {
                    console.log('Backdrop clicked');
                    // Tutup semua modal yang terbuka
                    document.querySelectorAll('.modal.show').forEach(modal => {
                        const bsModal = bootstrap.Modal.getInstance(modal);
                        if (bsModal) {
                            bsModal.hide();
                        }
                    });
                }
            });
            
            // 2. Fix untuk close button
            document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    console.log('Close button clicked');
                    e.preventDefault();
                    
                    // Dapatkan modal terdekat
                    const modal = this.closest('.modal');
                    if (modal) {
                        const bsModal = bootstrap.Modal.getInstance(modal);
                        if (bsModal) {
                            bsModal.hide();
                        }
                    }
                });
            });
            
            // 3. Enable click outside modal content
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    // Jika klik di luar .modal-content (di backdrop area modal)
                    if (e.target === this) {
                        console.log('Clicked outside modal content');
                        const bsModal = bootstrap.Modal.getInstance(this);
                        if (bsModal) {
                            bsModal.hide();
                        }
                    }
                });
            });
            
        });
    </script> --}}
    
    @stack('scripts')
</body>
</html>