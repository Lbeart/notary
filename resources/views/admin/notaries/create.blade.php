@extends('layouts.app')

@section('title', 'Krijo Noter të Ri')

@section('content')
<div class="container mt-5">
    <h1>Shto Noter të Ri</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.notaries.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Emri</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Mbiemri</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Qyteti</label>
            <select name="city_id" class="form-select" required>
                <option value="">Zgjedh qytetin</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Telefoni</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>

        <div class="mb-3">
            <label>Adresa</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Ruaj</button>
    </form>
</div>
@endsection
