@extends('layouts.app')

@section('title', 'Lista e Noterëve')

@section('content')
<div class="container mt-5">
    <h1>Lista e Noterëve</h1>

    <a href="{{ route('admin.notaries.create') }}" class="btn btn-success mb-3">Shto Noter të Ri</a>
    
    <!-- Butoni për t'u kthyer te admin dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3 ms-2">Kthehu te Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Emri</th>
                <th>Mbiemri</th>
                <th>Email</th>
                <th>Qyteti</th>
                <th>Telefoni</th>
                <th>Veprime</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notaries as $notary)
                <tr>
                    <td>{{ $notary->user->name }}</td>
                    <td>{{ $notary->user->last_name }}</td>
                    <td>{{ $notary->user->email }}</td>
                    <td>{{ $notary->city->name }}</td>
                    <td>{{ $notary->phone }}</td>
                    <td>
                        <a href="{{ route('admin.notaries.edit', $notary->id) }}" class="btn btn-primary btn-sm">Edito</a>
                        <form action="{{ route('admin.notaries.destroy', $notary->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Je i sigurt?');" type="submit" class="btn btn-danger btn-sm">Fshi</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $notaries->links() }}
</div>
@endsection
