@extends('layouts.app')

@section('title', 'Dashboardi i Noterit')

@section('content')
<div class="container mt-4">
    <h1>Mirësevini, {{ auth()->user()->name }}</h1>

    <h3 class="mt-5">Oraret e tua të punës</h3>
    @if ($appointmentSlots->isEmpty())
        <p>Nuk ke orare të regjistruara.</p>
    @else
        <ul>
            @foreach ($appointmentSlots as $slot)
                <li>{{ $slot->date }} - {{ $slot->start_time }} deri {{ $slot->end_time }}</li>
            @endforeach
        </ul>
    @endif

    <h3 class="mt-5">Rezervimet e tua</h3>
    @if ($bookings->isEmpty())
        <p>Nuk ke rezervime.</p>
    @else
        <ul>
            @foreach ($bookings as $booking)
                <li>
                    {{ $booking->user->name }} ka rezervuar me ty më {{ $booking->appointmentSlot->date }} në orën {{ $booking->appointmentSlot->start_time }}
                    <a href="{{ route('notary.booking.pdf', $booking->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
    Shkarko PDF
</a>
                </li>
            @endforeach
        </ul>
    @endif
    <a href="{{ route('notary.slots.create') }}" class="btn btn-success mb-4">Shto Orar të Lirë</a>
</div>
@endsection