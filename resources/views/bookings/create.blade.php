@extends('layouts.app')

@section('title', 'Krijo Rezervim')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Rezervo një takim me noterin: <strong>{{ $notary->user->name }}</strong></h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <input type="hidden" name="notary_id" value="{{ $notary->id }}">

        <div class="mb-3">
            <label for="appointment_slot_id" class="form-label">Zgjedh datën dhe orarin</label>
            <select name="appointment_slot_id" id="appointment_slot_id" class="form-select" required>
                <option value="">Zgjedh një slot</option>
                @foreach($slots as $slot)
                    <option value="{{ $slot->id }}">
                        {{ $slot->date }} | {{ $slot->start_time }} - {{ $slot->end_time }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="service_type_id" class="form-label">Lloji i shërbimit</label>
            <select name="service_type_id" id="service_type_id" class="form-select" required>
                <option value="">Zgjedh shërbimin</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Përshkrimi (opsionale)</label>
            <textarea name="description" id="description" rows="3" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Rezervo Takimin</button>
    </form>
</div>
@endsection
