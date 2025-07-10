<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Dashboardi i Noterit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 20px;
            padding: 40px 20px;
        }
        .sidebar {
            background-color: #001f3f;
            padding: 20px;
            border-radius: 12px;
            color: white;
            height: 100%;
        }
        .sidebar h4 {
            margin-bottom: 15px;
        }
        .sidebar a, .sidebar form button {
            display: block;
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            text-decoration: none;
            background: none;
            border: none;
            text-align: left;
        }
        .sidebar a:hover, .sidebar a.active, .sidebar form button:hover {
            background-color: #0074cc;
        }
        .main-content {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .booking-card {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="dashboard-layout">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>📋 Menu</h4>
        <a href="{{ route('notary.dashboard') }}" class="active">Rezervimet për Sot</a>
        <a href="{{ route('notary.booking.monthly') }}">📊 Rezervimet Mujore</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">🚪 Dil</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="mb-4">📅 Rezervimet për sot ({{ \Carbon\Carbon::today()->format('d/m/Y') }})</h2>

        <!-- Kërkimi -->
        <form method="GET" action="{{ route('notary.dashboard') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="🔍 Kërko klientin (emër, mbiemër, email, telefon)..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Kërko</button>
                @if(request('search'))
                    <a href="{{ route('notary.dashboard') }}" class="btn btn-outline-secondary">✖ Fshi</a>
                @endif
            </div>
        </form>

        @if ($bookings->isEmpty())
            <p class="text-muted">Sot nuk ke asnjë rezervim.</p>
        @else
            @foreach ($bookings as $booking)
                <div class="booking-card">
                    <strong>👤 Emri:</strong> {{ $booking->user->name }}<br>
                    <strong>👤 Mbiemri:</strong> {{ $booking->user->last_name }}<br>
                    <strong>📧 Email:</strong> {{ $booking->user->email }}<br>
                    <strong>📞 Telefoni:</strong> {{ $booking->user->phone }}<br>
                    <strong>🕒 Ora:</strong> {{ $booking->selected_time }}<br>
                    <strong>📝 Shërimi:</strong> {{ $booking->serviceType->name }}<br>

                    @php
                        $documentFields = array_filter($booking->getAttributes(), function ($value, $key) {
                            return str_ends_with($key, '_path') && $value;
                        }, ARRAY_FILTER_USE_BOTH);
                    @endphp

                    @foreach ($documentFields as $field => $path)
                        <div class="mt-2">
                            📄 {{ ucfirst(str_replace('_', ' ', str_replace('_path', '', $field))) }}:
                            <a href="{{ asset('storage/' . $path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Shiko</a>
                        </div>
                    @endforeach

                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('notary.booking.pdf', $booking->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">📄 PDF</a>
                        @if (count($documentFields))
                            <a href="{{ route('notary.booking.downloadDocuments', $booking->id) }}" class="btn btn-sm btn-outline-success">📦 Dokumentet</a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

</body>
</html>
