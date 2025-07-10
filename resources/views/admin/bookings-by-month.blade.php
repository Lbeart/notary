@extends('layouts.app')

@section('title', 'Rezervimet për muajin ' . $monthName)

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">📅 Rezervimet për muajin: <strong>{{ $monthName }}</strong></h2>

    <a href="{{ route('admin.bookings.monthly') }}" class="btn btn-secondary mb-4">← Kthehu te Përmbledhja Mujore</a>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Klienti</th>
                    <th>Noteri</th>
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
                        <td>{{ $booking->notary->user->name }}</td>
                        <td>{{ $booking->appointmentSlot->date }}</td>
                        <td>{{ $booking->selected_time }}</td>
                        <td>{{ $booking->serviceType->name }}</td>
                        <td>
                            <a href="{{ route('bookings.exportPdf', $booking->id) }}" class="btn btn-sm btn-outline-primary">
                                Shkarko PDF
                            </a>
                            
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nuk ka rezervime për këtë muaj.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
