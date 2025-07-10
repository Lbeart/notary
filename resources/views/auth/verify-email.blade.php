@extends('layouts.app')

@section('title', 'Verifiko Emailin')

@section('content')
<div class="container mt-5">
    <div class="alert alert-info">
        📧 Ju lutemi verifikoni adresën tuaj të emailit përpara se të vazhdoni.
    </div>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">
            Dërgo përsëri emailin e verifikimit
        </button>
    </form>
</div>
@endsection
