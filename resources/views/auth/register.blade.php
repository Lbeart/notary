@extends('layouts.app')

@section('title', 'Regjistrohu')

@section('content')
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Regjistrohu në sistem</h2>

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
            <label for="email" class="form-label">📧 Email</label>
            <input id="email" type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">🔒 Fjalëkalimi</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">🧑‍⚖️ Zgjidh Rolin</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">-- Zgjidh rolin --</option>
                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Përdorues</option>
                <option value="notary" {{ old('role') === 'notary' ? 'selected' : '' }}>Noter</option>
            </select>
        </div>

        {{-- Vetëm për Noterët --}}
        <div id="notaryFields" style="display: none;">
            <div class="mb-3">
                <label for="city_id" class="form-label">🏙️ Qyteti</label>
                <select name="city_id" id="city_id" class="form-select">
                    <option value="">-- Zgjidh qytetin --</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">📞 Telefoni</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">📍 Adresa</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Regjistrohu</button>
    </form>
</div>

<script>
    const roleSelect = document.getElementById('role');
    const notaryFields = document.getElementById('notaryFields');

    function toggleNotaryFields() {
        if (roleSelect.value === 'notary') {
            notaryFields.style.display = 'block';
        } else {
            notaryFields.style.display = 'none';
        }
    }

    // Initial call on load (for validation errors)
    toggleNotaryFields();

    // Update on change
    roleSelect.addEventListener('change', toggleNotaryFields);
</script>
@endsection
