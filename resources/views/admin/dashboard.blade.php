<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Paneli i Administratorit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Notary System</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link">Përshëndetje, {{ auth()->user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="padding: 0;">Dil</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Dashboard Content -->
<div class="container-fluid mt-4">
    <div class="row">
        <!-- MENU ANASH -->
        <div class="col-md-2 mb-3">
            <div class="list-group shadow-sm">
                <a href="{{ route('admin.notaries.create') }}" class="list-group-item list-group-item-action">➕ Krijo Noter të Ri</a>
                <a href="{{ route('admin.notaries.index') }}" class="list-group-item list-group-item-action">📄 Lista e Noterëve</a>
                <a href="{{ route('admin.bookings.monthly') }}" class="list-group-item list-group-item-action">📊 Përmbledhja Mujore</a>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">👤 Lista e Përdoruesve</a>
            </div>
        </div>

        <!-- PËRMBAJTJA KRYESORE -->
        <div class="col-md-10">
            <!-- KARTELAT STATISTIKORE -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-start-primary border-4">
                        <div class="card-body">
                            <div class="text-uppercase text-muted small mb-1">Total Rezervime</div>
                            <h5>{{ $totalBookings }}</h5>
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-start-success border-4">
                        <div class="card-body">
                            <div class="text-uppercase text-muted small mb-1">Total Noterë</div>
                            <h5>{{ $totalNotaries }}</h5>
                            <i class="fas fa-user-tie fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-start-info border-4">
                        <div class="card-body">
                            <div class="text-uppercase text-muted small mb-1">Total Përdorues</div>
                            <h5>{{ $totalUsers }}</h5>
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GRAFIKU -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Statistikat Mujore</h5>
                    <small class="text-muted">Përmbledhje mujore</small>
                </div>
                <div class="card-body">
                    <canvas id="bookingChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-4">
    <div class="container">
        &copy; {{ date('Y') }} Notary System. Të gjitha të drejtat të rezervuara.
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bookingChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: 'Rezervime',
                    data: {!! json_encode($monthlyBookings) !!},
                    backgroundColor: '#4e73df'
                },
                {
                    label: 'Noterë',
                    data: {!! json_encode($monthlyNotaries) !!},
                    backgroundColor: '#1cc88a'
                },
                {
                    label: 'Përdorues',
                    data: {!! json_encode($monthlyUsers) !!},
                    backgroundColor: '#9f5afd'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Numri' }
                },
                x: {
                    title: { display: true, text: 'Muaji' }
                }
            }
        }
    });
</script>
</body>
</html>
