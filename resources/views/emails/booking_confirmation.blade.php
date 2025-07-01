<!DOCTYPE html>
<html>
<head>
    <title>Konfirmimi i Rezervimit</title>
</head>
<body>
    <h1>Konfirmim Rezervimi</h1>
    <p>Përshëndetje {{ $booking->user->name }},</p>
    <p>Rezervimi juaj me noterin {{ $booking->notary->user->name }} është konfirmuar.</p>

    <p>Detajet:</p>
    <ul>
        <li>Data dhe Ora: {{ $booking->appointmentSlot->date }} - {{ $booking->appointmentSlot->start_time }}</li>
        <li>Lloji i Shërbimit: {{ $booking->serviceType->name }}</li>
        <li>Përshkrimi: {{ $booking->description ?? 'Pa përshkrim' }}</li>
    </ul>

    <p>Faleminderit që përdorët shërbimin tonë.</p>
</body>
</html>
