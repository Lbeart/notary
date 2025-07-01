{{-- resources/views/notaries/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2 class="mb-4">Lista e Noterëve</h2>

  <div class="row">
    @foreach ($notaries as $notary)
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ $notary->user->name }}</h5>
            <p class="card-text">Qyteti: {{ $notary->city->name }}</p>
            <p class="card-text">Telefoni: {{ $notary->phone }}</p>
            <a href="{{ route('notaries.show', $notary->id) }}" class="btn btn-primary">Shiko Profilin</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection