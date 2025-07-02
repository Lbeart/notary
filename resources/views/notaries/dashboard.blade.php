@extends('layouts.app')

@section('title', 'Dashboardi i Noterit')

@section('content')
<div class="container mt-4">
    <h1>Mirësevini, {{ auth()->user()->name }}</h1>

    <div class="d-flex flex-wrap gap-2 my-4">
        <a href="{{ route('notary.slots.create') }}" class="btn btn-success">➕ Shto Orar të Lirë</a>
        <a href="{{ route('notary.bookings.monthly') }}" class="btn btn-info text-white">📊 Rezervimet Mujore</a>
    </div>

    <h3 class="mt-5">📅 Orari i punës për sot ({{ \Carbon\Carbon::today()->format('d/m/Y') }})</h3>
    @if ($appointmentSlots->isEmpty())
        <div class="alert alert-warning">
            ⛔ Nuk ke orar të caktuar për sot. <a href="{{ route('notary.slots.create') }}">Shto orarin e sotëm</a> për të pranuar rezervime.
        </div>
    @else
        <ul class="list-group mb-4">
            @foreach ($appointmentSlots as $slot)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        {{ $slot->date }} – {{ $slot->start_time }} deri {{ $slot->end_time }}
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('notary.slots.edit', $slot->id) }}" class="btn btn-sm btn-warning">Edito</a>
                        <form action="{{ route('notary.slots.destroy', $slot->id) }}" method="POST" onsubmit="return confirm('A jeni i sigurt që dëshironi ta fshini këtë orar?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Fshi</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <h3 class="mt-5">✅ Rezervimet e tua për sot ({{ \Carbon\Carbon::today()->format('d/m/Y') }})</h3>
    @if ($bookings->isEmpty())
        <p class="text-muted">Sot nuk ke asnjë rezervim.</p>
    @else
        <ul class="list-group">
            @foreach ($bookings as $booking)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <strong>{{ $booking->user->name }}</strong> ka rezervuar për orën {{ $booking->selected_time }}
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('notary.booking.pdf', $booking->id) }}" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener noreferrer">
                            Shkarko PDF
                        </a>

                        @if ($booking->document_path)
                            <a href="{{ asset('storage/' . $booking->document_path) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                Shiko Dokumentin
                            </a>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
