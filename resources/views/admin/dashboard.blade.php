@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Dashboard</h1>

    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('admin.notaries.create') }}" class="btn btn-success">Krijo Noter të Ri</a>
        <a href="{{ route('admin.notaries.index') }}" class="btn btn-primary">Shiko Listën e Noterëve</a>
       <a href="{{ route('admin.bookings.monthly') }}" class="btn btn-info text-white">
    📊 Shiko Përmbledhjen Mujore
</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Rezervime</h5>
                    <h2 class="display-5">{{ $totalBookings }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Noterë</h5>
                    <h2 class="display-5">{{ $totalNotaries }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body text-center">
                    <h5>Total Përdorues</h5>
                    <h2 class="display-5">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
    </div>

 
@endsection
