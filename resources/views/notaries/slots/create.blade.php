@extends('layouts.app')

@section('title', 'Shto Orar të Lirë')

@section('content')
<div class="container mt-5">
    <h1>Shto Orar të Lirë</h1>

    <form method="POST" action="{{ route('notary.slots.store') }}">
        @csrf

        <div class="mb-3">
            <label for="date" class="form-label">Data</label>
            <input type="date" class="form-control" name="date" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Ora e fillimit</label>
            <input type="time" class="form-control" name="start_time" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Ora e përfundimit</label>
            <input type="time" class="form-control" name="end_time" required>
        </div>

        <button type="submit" class="btn btn-primary">Ruaj Orarin</button>
    </form>
</div>
@endsection
