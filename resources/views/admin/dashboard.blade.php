@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- MENU ANASH -->
        <div class="col-md-2">
            <div class="list-group shadow-sm">
                <a href="{{ route('admin.notaries.create') }}" class="list-group-item list-group-item-action">
                    ➕ Krijo Noter të Ri
                </a>
                <a href="{{ route('admin.notaries.index') }}" class="list-group-item list-group-item-action">
                    📄 Shiko Listën e Noterëve
                </a>
                <a href="{{ route('admin.bookings.monthly') }}" class="list-group-item list-group-item-action">
                    📊 Shiko Përmbledhjen Mujore
                </a>
            </div>
        </div>

        <!-- PËRMBAJTJA KRYESORE -->
        <div class="col-md-10">

            <!-- KARTELAT STATISTIKORE -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-start-primary border-4">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-uppercase mb-1">Total Rezervime</div>
                            <div class="h5 mb-0 fw-bold">{{ $totalBookings }}</div>
                            <div class="mt-2 text-primary"><i class="fas fa-calendar fa-2x"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-start-success border-4">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-uppercase mb-1">Total Noterë</div>
                            <div class="h5 mb-0 fw-bold">{{ $totalNotaries }}</div>
                            <div class="mt-2 text-success"><i class="fas fa-user-tie fa-2x"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-start-info border-4">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-uppercase mb-1">Total Përdorues</div>
                            <div class="h5 mb-0 fw-bold">{{ $totalUsers }}</div>
                            <div class="mt-2 text-info"><i class="fas fa-users fa-2x"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GRAFIKU -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Statistikat Mujore</h5>
                    <small class="text-muted">Përmbledhje e grafikut të performancës</small>
                </div>
                <div class="card-body">
                    <canvas id="bookingChart" height="100"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- FontAwesome për ikona -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Chart.js -->
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

@endpush
