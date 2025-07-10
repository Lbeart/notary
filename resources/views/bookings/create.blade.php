<!DOCTYPE html>  
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervo Takim Noterial</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 850px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 600;
        }
        .form-control, .form-select {
            border-radius: 6px;
        }
        .btn-primary {
            background-color: #004085;
            border: none;
        }
        .btn-primary:hover {
            background-color: #00366f;
        }
        .info-box {
            background-color: #e9f7fe;
            padding: 15px;
            border-left: 5px solid #0d6efd;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- 🔝 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">NotariOnline</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navItems">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navItems">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light ms-2">Dil</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Kyçu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Regjistrohu</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- 💡 KONTAINER -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">Rezervo Takim me Noterin: <strong>{{ $notary->user->name }}</strong></h2>

    <div class="info-box">
        <h5>Shërbimet që mund të kryhen nga noteri:</h5>
        <ul>
            <li><strong>Çështje familjare:</strong> Përpilimi i testamentit, hapja e testamentit, vërtetimi i gjallërisë, autorizime për fëmijë.</li>
            <li><strong>Pronësore:</strong> Shitblerje, hipotekë, qira, peng, uzufrukt, servitut, etj.</li>
            <li><strong>Ekonomike dhe pune:</strong> Akte të shoqërive, kontrata pune, autorizime për pension, deklarata.</li>
            <li><strong>Legalizime dhe certifikime:</strong> Nënshkrime, kontrata, kopje arkivore, ekstrakte, përkthime.</li>
            <li><strong>Ruajtje me vlerë:</strong> Testamente, dokumente, sende të çmuara, depozitime.</li>
        </ul>
    </div>

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

    <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="notary_id" value="{{ $notary->id }}">

        <div class="mb-3">
            <label for="service_type_id" class="form-label">Zgjidh Shërbimin</label>
            <select name="service_type_id" id="service_type_id" class="form-select" required>
                <option value="">-- Zgjidh Shërbimin --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="dynamicFields" class="border p-3 rounded d-none mt-3 bg-light">
            <h5 class="mb-3">Të dhënat e nevojshme për këtë shërbim:</h5>
            <div id="dynamicContent"></div>
        </div>

        <div class="mb-3">
            <label for="selected_datetime" class="form-label">Zgjidh Datën dhe Orën</label>
            <input type="text" id="selected_datetime" name="selected_time" class="form-control" required placeholder="Kliko për të zgjedhur...">
        </div>

        <button type="submit" class="btn btn-primary w-100">Dërgo Kërkesën</button>
    </form>
</div>

<script src="/js/notary-services.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#selected_datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            maxDate: new Date().fp_incr(90),
            time_24hr: true
        });
    });
</script>
</body>
</html>
