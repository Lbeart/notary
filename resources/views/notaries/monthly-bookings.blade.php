@extends('layouts.app')

@section('title', 'Rezervimet Mujore')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">📅 Rezervimet për muajin: <strong>{{ \Carbon\Carbon::now()->translatedFormat('F') }}</strong></h2>

    <a href="{{ route('notary.dashboard') }}" class="btn btn-secondary mb-4">← Kthehu te Dashboardi</a>
 <form method="GET" action="{{ route('notary.bookings.monthly') }}" class="mb-3">
    <label for="month" class="form-label">Zgjedh muajin:</label>
    <select id="month" name="month" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
        @foreach(range(1, 12) as $m)
            <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
        @endforeach
    </select>
</form>

    <div class="table-responsive">
        <table class="table table-striped align-middle text-center">
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
                        <td>{{ $booking->appointmentSlot->date }}</td>
                        <td>{{ $booking->selected_time }}</td>
                        <td>{{ $booking->serviceType->name }}</td>
                        <td>
                            <a href="{{ route('notary.booking.pdf', $booking->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                Shkarko PDF
                            </a>
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
@endsection
