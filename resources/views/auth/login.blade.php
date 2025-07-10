<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kyçu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .login-container {
            max-width: 450px;
            margin: 60px auto;
            padding: 35px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<!-- Navbar si tek home.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/">
            <img src="/img/logo.png" alt="Logo" height="40"> Notariz
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-3">
                <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pages</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Login Form -->
<div class="login-container">
    <h2>Kyçu në llogari</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">📧 Email</label>
            <input type="email" name="email" class="form-control" required autofocus value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">🔒 Fjalëkalimi</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3 text-end">
    <a href="{{ route('password.request') }}" class="text-decoration-none">Ke harruar fjalëkalimin?</a>
</div>

        <button type="submit" class="btn btn-primary">Kyçu</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>