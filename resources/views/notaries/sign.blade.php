@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dokumenti për Nënshkrim</h2>

    <div class="mb-3">
        <embed id="pdf-viewer" src="{{ asset('storage/' . $booking->document_path) }}" type="application/pdf" width="100%" height="600px">
    </div>

    <form id="signature-form" method="POST" action="{{ route('notary.booking.storeSignatureImage', $booking->id) }}">
        @csrf
        <input type="hidden" name="x" id="x">
        <input type="hidden" name="y" id="y">
        <input type="hidden" name="signature" id="signature">

        <p><strong>Zgjedh ku don me vendos nënshkrimin duke klikuar në dokumentin më poshtë:</strong></p>

        <canvas id="sign-canvas" width="800" height="200" style="border:1px solid #ccc;"></canvas><br>
        <button type="button" id="clear">Pastro</button>
        <br><br>

        <button type="submit" class="btn btn-primary mt-2">Nënshkruaj dhe Ruaj</button>
    </form>
</div>

<script>
    const canvas = document.getElementById('sign-canvas');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    canvas.addEventListener('mousedown', () => drawing = true);
    canvas.addEventListener('mouseup', () => drawing = false);
    canvas.addEventListener('mouseout', () => drawing = false);
    canvas.addEventListener('mousemove', draw);

    function draw(e) {
        if (!drawing) return;
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    }

    document.getElementById('clear').addEventListener('click', function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    document.getElementById('pdf-viewer').addEventListener('click', function (e) {
        const embed = e.target;
        const rect = embed.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        document.getElementById('x').value = x.toFixed(0);
        document.getElementById('y').value = y.toFixed(0);

        alert('Koordinatat u vendosën: X=' + x + ', Y=' + y);
    });

    document.getElementById('signature-form').addEventListener('submit', function (e) {
        const signatureInput = document.getElementById('signature');
        const imageData = canvas.toDataURL('image/png');
        signatureInput.value = imageData;
    });
</script>
@endsection
