<!DOCTYPE html> 
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Detajet e Rezervimit</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        .box { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
    </style>
</head>
<body>
    <h2>Detajet e Rezervimit</h2>

    <div class="box">
        <strong>Emri i Klientit:</strong> {{ $booking->user->name }}<br>
        <strong>Email:</strong> {{ $booking->user->email }}<br>

        {{-- Vetëm data, pa orë --}}
        <strong>Data:</strong> {{ \Carbon\Carbon::parse($booking->appointmentSlot->date)->format('d-m-Y') }}<br>

        {{-- Vetëm ora e zgjedhur --}}
        <strong>Ora e zgjedhur:</strong> {{ \Carbon\Carbon::parse($booking->selected_time)->format('H:i') }}<br>

        <strong>Noteri:</strong> {{ $booking->notary->user->name }}<br>
        <strong>Lloji i Shërbimit:</strong> {{ $booking->serviceType->name }}<br>
        <strong>Përshkrimi:</strong> {{ $booking->description ?? '---' }}
        @if ($signatureUrl)
    <div style="margin-top: 20px;">
        <strong>Nënshkrimi i Noterit:</strong><br>
        <img src="{{ $signatureUrl }}" alt="Nënshkrimi" style="width: 200px; height: auto;">
    </div>
@endif
    </div>

    <p style="margin-top: 30px;">Faleminderit për përdorimin e platformës Notary Appointment System.</p>
</body>
</html>
