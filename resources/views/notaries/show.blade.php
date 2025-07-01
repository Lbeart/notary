{{-- resources/views/notaries/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h3>{{ $notary->user->name }}</h3>
            <p><strong>Email:</strong> {{ $notary->user->email }}</p>
            <p><strong>Qyteti:</strong> {{ $notary->city->name }}</p>
            <p><strong>Telefoni:</strong> {{ $notary->phone }}</p>
            <p><strong>Adresa:</strong> {{ $notary->address }}</p>
            <p><strong>Biografi:</strong> {{ $notary->bio ?? 'Nuk ka biografi' }}</p>

            {{-- Optional: afisho oraret nëse i ke --}}
            {{-- <p><strong>Orari i lirë:</strong> ... </p> --}}

            <a href="{{ route('bookings.create', $notary->id) }}" class="btn btn-success mt-3">Rezervo një takim</a>
        </div>
    </div>
</div>
@endsection
