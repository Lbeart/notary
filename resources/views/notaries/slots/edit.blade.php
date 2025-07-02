@extends('layouts.app')

@section('title', 'Ndrysho Orarin e Punës')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-clock-history me-2"></i> Ndrysho Orarin e Punës
            </h4>
        </div>

        <div class="card-body">
            <form action="{{ route('notary.slots.update', $slot->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_time" class="form-label fw-semibold">
                            <i class="bi bi-clock me-1"></i> Ora e Fillimit
                        </label>
                        <input type="time"
                               name="start_time"
                               id="start_time"
                               value="{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="end_time" class="form-label fw-semibold">
                            <i class="bi bi-clock-fill me-1"></i> Ora e Përfundimit
                        </label>
                        <input type="time"
                               name="end_time"
                               id="end_time"
                               value="{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}"
                               class="form-control"
                               required>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('notary.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kthehu
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Ruaj Ndryshimet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
