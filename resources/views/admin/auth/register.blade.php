<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --background: #013023;
            --button: #084908;
            --button2: #32de32;
            --hover-button: #00695c;
            --color-text: #817e7e;
            --text-2: #444444;
            --white: #ffffff;
            --border-color: rgba(255, 255, 255, 0.2);
        }

        body {
            background-color: #333;
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('images/background.jpg') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            z-index: -1;
            filter: brightness(80%) blur(3px) grayscale(20%);
        }

        .register-container {
            width: 100%;
            max-width: 400px;
            background: var(--hover-button);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--border-color);
        }

        .btn-primary {
            background-color: var(--button2);
            color: #000;
            font-weight: 700;
            border: none;
        }

        .btn-primary:hover {
            background-color: #00c3ff;
            color: #fff;
        }

        .btn-outline {
            background: transparent;
            color: var(--white);
            border: 1px solid var(--border-color);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--button2);
            color: var(--white);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header text-center mb-4">
            <h1 class="h3 text-white">Registrasi Admin</h1>
            <p class="text-white">Buat akun baru untuk mengakses dashboard</p>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('admin.register.post') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label text-white">Username</label>
                <div class="input-icon">
                    <input type="text" class="form-control" id="username" name="username" 
                           value="{{ old('username') }}" required placeholder="Masukkan username">
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-text text-white">5-15 karakter</div>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label text-white">Email</label>
                <div class="input-icon">
                    <input type="email" class="form-control" id="email" name="email" 
                           value="{{ old('email') }}" required placeholder="Masukkan email">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label text-white">Password</label>
                <div class="input-icon">
                    <input type="text" class="form-control" id="password" name="password" required 
                           placeholder="Masukkan password">
                    <i class="fas fa-key"></i>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">Daftar</button>
            <a href="{{ route('admin.login') }}" class="btn btn-outline w-100">Kembali ke Login</a>
        </form>
        
        <div class="form-footer text-center mt-3">
            <p class="text-white mb-0">
                Sudah punya akun? <a href="{{ route('admin.login') }}" class="text-warning text-decoration-none">Login disini</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>