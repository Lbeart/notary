@extends('layouts.app')

@section('title', 'Edito Përdorues')

@section('content')
<div class="container mt-5">
    <h1>Edito Përdorues</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Emri</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mbiemri</label>
            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Telefoni</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
        </div>
        <div class="mb-3">
    <label>Fjalëkalimi i Ri (opsional)</label>
    <input type="password" name="password" class="form-control" placeholder="Lëre bosh nëse nuk don me e ndryshu">
</div>

        <button type="submit" class="btn btn-primary">Ruaj Ndryshimet</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Anulo</a>
    </form>
</div>
@endsection