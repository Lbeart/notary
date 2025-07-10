<x-mail::message>
# Përshëndetje {{ $booking->user->name }},

Rezervimi juaj është pranuar me sukses nga noteri **{{ $booking->notary->user->name }}**.

**Detajet e rezervimit:**
- 📄 Shërbimi: {{ $booking->serviceType->name }}
- 📅 Data: {{ \Carbon\Carbon::parse($booking->selected_time)->format('d/m/Y') }}
- 🕒 Ora: {{ \Carbon\Carbon::parse($booking->selected_time)->format('H:i') }}

<x-mail::button :url="route('home')">
Shiko Detajet
</x-mail::button>

Faleminderit që na zgjodhët!<br>
{{ config('app.name') }}
</x-mail::message>
