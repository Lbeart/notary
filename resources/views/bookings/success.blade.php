@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="alert alert-success">
        <h3>Rezervimi u bë me sukses!</h3>
        <p>Faleminderit që rezervuat një takim me noterin.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Kthehu në faqen kryesore</a>
    </div>

    <a href="{{ route('bookings.exportPdf', $booking->id) }}" class="btn btn-primary mt-3">Shkarko PDF</a>

</div>
@endsection
