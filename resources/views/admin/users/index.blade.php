@extends('layouts.app')

@section('title', 'Lista e Përdoruesve')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">📋 Lista e Përdoruesve</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">↩ Kthehu te Dashboard</a>
   <table class="table table-bordered table-striped shadow-sm">
    <thead class="table-light">
        <tr>
            <th>Emri</th>
            <th>Mbiemri</th>
            <th>Email</th>
            <th>Telefoni</th>
            <th>Data e Regjistrimit</th>
            <th>Veprime</th> <!-- ✅ Shtuar -->
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edito</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Je i sigurt që do ta fshish këtë përdorues?');" class="btn btn-sm btn-danger">
                            Fshi
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Asnjë përdorues i regjistruar.</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
