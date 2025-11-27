<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <!-- Font -->
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
                <h2>Sign In User</h2>
            </div>
            
            @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            
            <form class="form-login" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-row">
                    <label for="email">Masuk menggunakan akun anda</label>
                    <input type="email" id="email" name="email" placeholder="Masukan email" value="{{ old('email') }}" required>
                </div>

                <div class="form-row">
                    <input type="password" id="password" name="password" placeholder="Kata sandi" required>
                </div>

                <h4 onclick="window.location.href='{{ route('password.request') }}'" style="cursor: pointer; color: var(--white);">Lupa kata sandi?</h4>

                <div class="form-row full">
                    <button type="submit">Masuk</button>
                </div>
            </form>

            <a href="{{ route('register') }}">Belum memiliki akun?</a>

        </div>
        <div class="right">
            <img src="{{ asset('avatar/SignIn.png') }}" alt="Sign In">
        </div>
    </section>
</body>
</html>