<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar | Kejora Mart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #020617);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            max-width: 900px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,.35);
        }
        .left {
            background: linear-gradient(135deg, #facc15, #f59e0b);
            padding: 50px;
            color: #0f172a;
        }
        .right {
            padding: 50px;
            background: #fff;
        }
        .btn-primary {
            background: #facc15;
            border: none;
            color: #0f172a;
            font-weight: 700;
        }
        .btn-primary:hover {
            background: #f59e0b;
            color: #0f172a;
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

<div class="card auth-card w-100">
    <div class="row g-0">

        <!-- KIRI -->
        <div class="col-md-5 d-none d-md-flex flex-column justify-content-center left">
                <img src="{{ asset('logo.png') }}" class="brand-logo" alt="Kejora Mart Logo">
            <h2 class="fw-bold">Kejora Mart</h2>
            <p class="mt-3">
                Sistem kasir & manajemen toko modern.<br>
                Cepat • Aman • Mudah
            </p>
        </div>

        <!-- KANAN -->
        <div class="col-md-7 right">
            <h3 class="fw-bold mb-2">Buat Akun</h3>
            <p class="text-muted mb-4">Daftar untuk mulai menggunakan sistem</p>

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
    @csrf

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" required>
                    </div>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label class="form-label">Daftar Sebagai</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>
                            Kasir
                        </option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                    </select>
                </div>

                <!-- Kode Admin -->
                <div class="mb-3 d-none" id="adminCodeBox">
                    <label class="form-label">Kode Admin</label>
                    <input type="password" name="admin_code"
                           class="form-control"
                           placeholder="Masukkan kode admin">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <!-- Konfirmasi -->
                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password_confirmation"
                               class="form-control" required>
                    </div>
                </div>

              <button type="submit" class="btn btn-primary w-100 py-2 fw-bold"> Daftar Sekarang
              </button>




            </form>

            <p class="text-center mt-4">
                Sudah punya akun?
                <a href="{{ url('/login') }}" class="fw-bold text-warning">Masuk</a>
            </p>
           
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
        </div>
    </div>
</div>


<script>
    const roleSelect = document.getElementById('role');
    const adminBox = document.getElementById('adminCodeBox');

    function toggleAdminCode() {
        adminBox.classList.toggle('d-none', roleSelect.value !== 'admin');
    }

    roleSelect.addEventListener('change', toggleAdminCode);
    toggleAdminCode();
</script>

</body>
</html>