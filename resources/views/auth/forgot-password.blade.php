<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi - Warung Tita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <section class="hero">
        <div class="left">
            <div class="title">
                <h2>Forgot Password</h2>
            </div>

            <h3>Masukan data anda</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form class="form-login" method="POST" action="{{ route('password.reset') }}">
                @csrf
                
                <div class="form-row">
                    <label for="email">Masukan email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                </div>

                <div class="form-row">
                    <label for="password">Buat kata sandi</label>
                    <input type="password" id="password" name="password" placeholder="Kata sandi" required>
                </div>

                <div class="form-row">
                    <label for="password_confirmation">Konfirmasi kata sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi kata sandi" required>
                </div>

                <div class="form-row full">
                    <button type="submit">Reset Password</button>
                </div>
            </form>

            <a href="{{ route('login') }}">Sudah memiliki akun?</a>
        </div>
        <div class="right">
            <img src="{{ asset('avatar/Forgot_password.png') }}" alt="Forgot Password Illustration">
        </div>
    </section>
</body>
</html>