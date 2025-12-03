<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
        
        .login-container {
            width: 100%;
            max-width: 400px;
            background: var(--hover-button);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--border-color);
        }

        .btn-login {
            background-color: var(--button2);
            color: #000;
            font-weight: 700;
        }

        .btn-login:hover {
            background-color: #00c3ff;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header text-center mb-4">
            <h1 class="h3 text-white">Admin Login</h1>
            <p class="text-white">Masuk menggunakan akun admin Anda</p>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label text-white">Username</label>
                <input type="text" class="form-control" id="username" name="username" required 
                       value="{{ old('username') }}" placeholder="Masukan username">
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label text-white">Password</label>
                <input type="password" class="form-control" id="password" name="password" required 
                       placeholder="Kata sandi">
            </div>
            
            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>
        
        <div class="register-link text-center mt-3">
            <p class="text-white mb-0">Belum memiliki akun? 
                <a href="{{ route('admin.register') }}" class="text-warning text-decoration-none">Daftar admin</a>
            </p>
        </div>
    </div>
</body>
</html>