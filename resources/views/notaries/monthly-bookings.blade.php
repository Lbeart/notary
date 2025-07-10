<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Rezervimet Mujore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 40px 20px;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .search-box {
            max-width: 300px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container">
    <h2 class="mb-4">📅 Rezervimet për muajin: <strong>{{ $monthName }}</strong></h2>

    <a href="{{ route('notary.dashboard') }}" class="btn btn-secondary mb-4">← Kthehu te Dashboardi</a>

    <form method="GET" action="{{ route('notary.booking.monthly') }}" class="mb-4 d-flex flex-wrap gap-2 align-items-center">
        <label for="month" class="form-label mb-0">Zgjedh muajin:</label>
        <select id="month" name="month" class="form-select w-auto" onchange="this.form.submit()">
            @foreach(range(1, 12) as $m)
                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>
    </form>

    <input type="text" id="searchInput" class="form-control search-box" placeholder="🔍 Kërko klientin..." onkeyup="filterTable()">

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center" id="bookingTable">
            <thead class="table-light">
                <tr>
                    <th>Klienti</th>
                    <th>Data</th>
                    <th>Ora</th>
                    <th>Shërbimi</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->selected_time)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->selected_time)->format('H:i') }}</td>
                        <td>{{ $booking->serviceType->name }}</td>
                        <td>
                            <a href="{{ route('notary.booking.pdf', $booking->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                Shkarko PDF
                            </a>
                        </td>
                        <td class="d-flex justify-content-center gap-2">
    <a href="{{ route('notary.booking.pdf', $booking->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
        PDF
    </a>
    <a href="{{ route('notary.booking.documents', $booking->id) }}" class="btn btn-sm btn-outline-success">
        ZIP
    </a>
      <form action="{{ route('notary.booking.sendEmail', $booking->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-info">
            📧 Email
        </button>
    </form>
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nuk ka rezervime për këtë muaj.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function filterTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll("#bookingTable tbody tr");

    rows.forEach(row => {
        const nameCell = row.cells[0];
        if (nameCell && nameCell.textContent.toLowerCase().includes(filter)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
</script>

</body>
</html>
