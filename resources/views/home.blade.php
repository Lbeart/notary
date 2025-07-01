@extends('layouts.app')

@section('title', 'Noterët')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista e Noterëve</h1>

    <!-- Filter by city -->
    <form method="GET" action="{{ route('home') }}" class="mb-4 row g-3">
        <div class="col-md-4">
            <select name="city" class="form-select" onchange="this.form.submit()">
                <option value="">Zgjedh qytetin</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- List of notaries -->
    <div class="row">
        @forelse($notaries as $notary)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $notary->user->name }}</h5>
                        <p class="card-text">
                            Qyteti: {{ $notary->city->name }}<br>
                            Telefoni: {{ $notary->phone }}
                        </p>
                        <a href="{{ route('notaries.show', $notary->id) }}" class="btn btn-primary">
                            Shiko më shumë
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>Nuk ka noterë për këtë qytet.</p>
        @endforelse
    </div>
</div>
@endsection
