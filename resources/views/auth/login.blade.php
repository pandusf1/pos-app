<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Kejora Mart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #111827, #1f2933);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-wrapper {
            display: flex;
            max-width: 900px;
            width: 100%;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.35);
        }

        /* LEFT BRAND */
        .brand-side {
            background: linear-gradient(160deg, #facc15, #f59e0b);
            color: #111827;
            width: 45%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-side h1 {
            font-weight: 800;
            font-size: 34px;
            letter-spacing: 1px;
        }

        .brand-side p {
            font-size: 15px;
            opacity: 0.9;
        }

        /* RIGHT FORM */
        .form-side {
            width: 55%;
            padding: 40px;
        }

        .form-title {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .form-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 25px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #facc15;
            box-shadow: 0 0 0 0.15rem rgba(250,204,21,.35);
        }

        .btn-login {
            background: #facc15;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            color: #111827;
        }

        .btn-login:hover {
            background: #f59e0b;
            color: #111827;
        }

        .input-group-text {
            background: #f3f4f6;
            border-radius: 10px 0 0 10px;
        }

        .footer {
            font-size: 11px;
            color: #6b7280;
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }
            .brand-side, .form-side {
                width: 100%;
            }
            .brand-side {
                text-align: center;
            }
        }

        .brand-logo {
    width: 120px;
    margin-bottom: 20px;
}
.brand-logo {
    box-shadow: 0 10px 25px rgba(0,0,0,.25);
}

    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- LEFT -->
    <div class="brand-side text-center text-md-start">
    <img src="{{ asset('logo.png') }}" class="brand-logo" alt="Kejora Mart Logo">
        <h1>Kejora Mart</h1>
        <p>
            Sistem Kasir & Manajemen Toko Modern<br>
            Cepat • Aman • Mudah
        </p>
    </div>

    <!-- RIGHT -->
    <div class="form-side">

        <div class="mb-4">
            <h4 class="form-title">Masuk Akun</h4>
            <div class="form-subtitle">Silakan login untuk melanjutkan</div>
        </div>

        @if ($errors->has('login'))
            <div class="alert alert-danger py-2">
                {{ $errors->first('login') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label small">Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small">Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
 <div class="mb-3">
                <label class="form-label small">Role</label>
                <select name="role" class="form-select" required>
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                </select>
</div>
           <button type="submit" class="btn btn-login w-100 py-2 fw-bold">
    Masuk
</button>


            <p class="text-center mt-3">
            Tidak punya akun?
            <a href="{{ url('/register') }}" class="text-warning fw-bold">
    Buat akun sekarang!
</a>

            </p>
</form>
           <div class="my-3 text-center text-muted small">
    — atau masuk dengan —
</div>

<div class="d-flex gap-2">
    <a href="{{ url('/auth/google') }}" class="btn btn-light w-50 border">
        <img src="https://developers.google.com/identity/images/g-logo.png"
             width="18" class="me-2">
        Google
    </a>

    <a href="{{ url('/auth/facebook') }}" class="btn btn-light w-50 border">
        <i class="bi bi-facebook text-primary me-2"></i>
        Facebook
    </a>
</div>


        <div class="footer">
            © 2026 Kejora Mart
        </div>

    </div>
</div>

</body>
</html>
