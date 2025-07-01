{{-- resources/views/notaries/book.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Rezervo takim me: {{ $notary->user->name }}</h3>

    <form action="{{ route('bookings.store') }}" method="POST" class="mt-4">
        @csrf

        <input type="hidden" name="notary_id" value="{{ $notary->id }}">

        <div class="mb-3">
            <label for="service_type_id" class="form-label">Shërbimi</label>
            <select name="service_type_id" class="form-select" required>
                <option value="">Zgjedh shërbimin</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="appointment_time" class="form-label">Orari</label>
            <select name="appointment_time" class="form-select" required>
                <option value="">Zgjedh orarin</option>
                @foreach($slots as $slot)
                    <option value="{{ $slot->time }}">{{ $slot->time }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Përshkrimi</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Konfirmo rezervimin</button>
    </form>
</div>
@endsection
