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
        <strong>Data:</strong> {{ $booking->appointmentSlot->date }}<br>
        <strong>Ora:</strong> {{ $booking->appointmentSlot->start_time }} - {{ $booking->appointmentSlot->end_time }}<br>
        <strong>Noteri:</strong> {{ $booking->notary->user->name }}<br>
        <strong>Përshkrimi:</strong> {{ $booking->description ?? '---' }}
    </div>

    <p style="margin-top: 30px;">Faleminderit për përdorimin e platformës Notary Appointment System.</p>
</body>
</html>
