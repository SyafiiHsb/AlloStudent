<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - AlloStudent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background-color: #e7f1ff; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .register-card { width: 100%; max-width: 400px; border: none; border-radius: 15px; }</style>
</head>
<body>
    <div class="card register-card shadow p-4">
        <div class="text-center mb-4">
            <h3 class="text-primary fw-bold">Daftar Akun</h3>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="{{ route('login') }}">Login</a></small>
        </div>
    </div>
</body>
</html>