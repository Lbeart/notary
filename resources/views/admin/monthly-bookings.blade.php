@extends('layouts.app')

@section('title', 'Përmbledhja Mujore e Rezervimeve')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">📅 Përmbledhja mujore e rezervimeve për vitin 2025</h2>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-4">← Kthehu te Dashboard</a>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Muaji</th>
                    <th>Total Pagesa (€)</th>
                    <th>Shiko Detaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($months as $month)
                    <tr>
                        <td>{{ $month['name'] }}</td>
                        <td>{{ $month['total'] }} €</td>
                        <td>
                            <a href="{{ route('admin.bookings.byMonth', ['month' => $month['month']]) }}"
                               class="btn btn-sm btn-outline-primary">
                                Shiko Rezervimet
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
