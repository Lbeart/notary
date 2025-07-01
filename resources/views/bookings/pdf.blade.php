<!DOCTYPE html>
<html>
<head>
    <title>Rezervimi - PDF</title>
</head>
<body>
    <h1>Konfirmimi i Rezervimit</h1>

    <p>Noteri: {{ $booking->notary->user->name }}</p>
    <p>Data dhe Ora: {{ $booking->appointmentSlot->date }} - {{ $booking->appointmentSlot->start_time }}</p>
    <p>Lloji i Shërbimit: {{ $booking->serviceType->name }}</p>
    <p>Përshkrimi: {{ $booking->description ?? 'Pa përshkrim' }}</p>
    <p><strong>Ora e zgjedhur:</strong> {{ $booking->selected_time }}</p>
</body>
</html>
