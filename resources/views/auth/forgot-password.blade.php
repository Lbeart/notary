<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Reset Fjalëkalimin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4 text-center">🔑 Harrove fjalëkalimin?</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Shkruaj emailin tënd</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary w-100">Dërgo linkun për ndërrimin e fjalëkalimit</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
