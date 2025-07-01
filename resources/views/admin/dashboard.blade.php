@extends('layouts.app') 

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <h1>Dashboard</h1>
 
    <div class="mb-4 d-flex gap-2">
        <a href="{{ route('admin.notaries.create') }}" class="btn btn-success">Krijo Noter të Ri</a>
        <a href="{{ route('admin.notaries.index') }}" class="btn btn-primary">Shiko Listën e Noterve</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 p-3">
                <h5>Total Rezervime</h5>
                <h2>{{ $totalBookings }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 p-3">
                <h5>Total Noterë</h5>
                <h2>{{ $totalNotaries }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3 p-3">
                <h5>Total Përdorues</h5>
                <h2>{{ $totalUsers }}</h2>
            </div>
        </div>
    </div>

    <h3>Rezervimet e fundit</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Përdoruesi</th>
                <th>Noteri</th>
                <th>Data dhe Ora</th>
                <th>Lloji i Shërbimit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latestBookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->notary->user->name }}</td>
                    <td>{{ $booking->appointmentSlot->date }} {{ $booking->appointmentSlot->start_time }}</td>
                    <td>{{ $booking->serviceType->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
