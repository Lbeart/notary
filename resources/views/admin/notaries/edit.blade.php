@extends('layouts.app')

@section('title', 'Edito Noter')

@section('content')
<div class="container mt-5">
    <h1>Edito Noter</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.notaries.update', $notary->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Emri</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $notary->user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $notary->user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Password (lëre bosh nëse nuk do ta ndryshosh)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Qyteti</label>
            <select name="city_id" class="form-select" required>
                <option value="">Zgjedh qytetin</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id', $notary->city_id) == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Telefoni</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $notary->phone) }}" required>
        </div>

        <div class="mb-3">
            <label>Adresa</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $notary->address) }}" required>
        </div>

        <!-- Nëse ke slots, mund t'i shtosh këtu sipas UI që ke ose textarea për JSON -->

        <button type="submit" class="btn btn-primary">Ruaj Ndryshimet</button>
        <a href="{{ route('admin.notaries.index') }}" class="btn btn-secondary ms-2">Anulo</a>
    </form>
</div>
@endsection
