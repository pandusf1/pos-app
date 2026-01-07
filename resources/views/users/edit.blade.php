@extends('layout')
@section('content')

<style>
/* ================= CARD ================= */
.page-card {
    background: #fff;
    border-radius: 26px;
    padding: 32px;
    box-shadow: 0 25px 50px rgba(15,23,42,.08);
}

/* ================= HEADER ================= */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
}

.page-title {
    font-size: 20px;
    font-weight: 700;
}

/* ================= FORM ================= */
.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.form-control,
.form-select {
    border-radius: 14px;
    padding: 11px 14px;
    border: 1px solid #e5e7eb;
}

.form-control:focus,
.form-select:focus {
    border-color: #111827;
    box-shadow: none;
}

/* ================= BUTTON ================= */
.btn-back {
    border-radius: 14px;
    border: 1.5px solid #9ca3af;
    padding: 8px 18px;
    background: transparent;
    color: #374151;
}

.btn-back:hover {
    background: #f3f4f6;
}

.btn-save {
    background: #111827;
    color: #fff;
    border-radius: 14px;
    padding: 10px 22px;
    border: none;
}

.btn-save:hover {
    opacity: .9;
}

.btn-cancel {
    border-radius: 14px;
    padding: 10px 22px;
    border: 1.5px solid #9ca3af;
    background: transparent;
    color: #374151;
}

.btn-cancel:hover {
    background: #f3f4f6;
}

.btn-toggle-password {
    position: absolute;
    top: 50%;
    right: 14px;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 16px;
    color: #6b7280;
}

.btn-toggle-password:hover {
    color: #111827;
}

</style>

<div class="page-card">

    <!-- ================= HEADER ================= -->
    <div class="page-header">
        <div class="page-title">Edit Data User</div>

        <a href="{{ route('users.index') }}" class="btn-back">
            ← Kembali
        </a>
    </div>

    <!-- ================= FORM ================= -->
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">

            <!-- Nama -->
            <div class="col-md-6">
                <label class="form-label">Nama</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $user->name }}"
                       required>
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ $user->email }}"
                       required>
            </div>

            <!-- Password -->
            <div class="col-md-6">
    <label class="form-label">Password</label>

    <div class="position-relative">
        <input type="password"
               name="password"
               id="password"
               class="form-control pe-5"
               required>

        <button type="button"
                class="btn-toggle-password"
                onclick="togglePassword()"
                aria-label="Toggle password">
            👁️
        </button>
    </div>
</div>


            <!-- Role -->
            <div class="col-md-6">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                    <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>
                        Kasir
                    </option>
                </select>
            </div>

        </div>

        <!-- ================= FOOTER BUTTON ================= -->
        <div class="d-flex justify-content-end gap-2 mt-5">
            <a href="{{ route('users.index') }}" class="btn-cancel">
                Batal
            </a>
            <button type="submit" class="btn-save">
                Simpan User
            </button>
        </div>

    </form>

</div>
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const btn = event.currentTarget;

    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁️';
    }
}
</script>

@endsection
