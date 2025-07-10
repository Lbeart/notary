@extends('layouts.app')

@section('title', 'Regjistrohu')

@section('content')
<style>
    body {
        background: #f2f4f7;
    }
    .register-container {
        max-width: 520px;
        background: #fff;
        padding: 35px;
        margin: 50px auto;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .register-container h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: 600;
        color: #2c3e50;
    }

    .form-label {
        font-weight: 500;
    }

    .form-control, .form-select {
        border-radius: 6px;
    }

    .btn-primary {
        background-color: #3498db;
        border: none;
        transition: 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .alert-danger {
        font-size: 0.9rem;
    }
</style>

<div class="register-container">
    <h2>Regjistrohu në sistem</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">👤 Emri</label>
            <input id="name" type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">👤 Mbiemri</label>
            <input id="last_name" type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">📧 Email</label>
            <input id="email" type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">📞 Telefoni</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">🔒 Fjalëkalimi</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">🧑‍⚖️ Roli</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">-- Zgjidh rolin --</option>
                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Përdorues</option>
                <option value="notary" {{ old('role') === 'notary' ? 'selected' : '' }}>Noter</option>
            </select>
        </div>

        <div id="notaryFields" style="display: none;">
            <div class="mb-3">
                <label for="city_id" class="form-label">🏙️ Qyteti</label>
                <select name="city_id" id="city_id" class="form-select">
                    <option value="">-- Zgjidh qytetin --</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">📍 Adresa</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">🚀 Regjistrohu</button>
    </form>
</div>

<script>
    const roleSelect = document.getElementById('role');
    const notaryFields = document.getElementById('notaryFields');

    function toggleNotaryFields() {
        notaryFields.style.display = roleSelect.value === 'notary' ? 'block' : 'none';
    }

    toggleNotaryFields();
    roleSelect.addEventListener('change', toggleNotaryFields);
</script>
@endsection
