@extends('layouts.app')

@section('title', 'Krijo Rezervim')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Rezervo një takim me noterin: <strong>{{ $notary->user->name }}</strong></h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="notary_id" value="{{ $notary->id }}">

        <div class="mb-3">
            <label for="appointment_slot_id" class="form-label">Zgjidh datën</label>
            <select name="appointment_slot_id" id="appointment_slot_id" class="form-select" required>
                <option value="">Zgjidh datën</option>
                @foreach($slots as $slot)
                    @if(\Carbon\Carbon::parse($slot->date)->isToday() || \Carbon\Carbon::parse($slot->date)->isFuture())
                        <option 
                            value="{{ $slot->id }}" 
                            data-start="{{ $slot->start_time }}" 
                            data-end="{{ $slot->end_time }}">
                            {{ \Carbon\Carbon::parse($slot->date)->format('d/m/Y') }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="selected_time" class="form-label">Zgjidh orarin</label>
            <select name="selected_time" id="selected_time" class="form-select" required>
                <option value="">Zgjidh orën</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="service_type_id" class="form-label">Lloji i shërbimit</label>
            <select name="service_type_id" id="service_type_id" class="form-select" required>
                <option value="">Zgjidh shërbimin</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Përshkrimi (opsionale)</label>
            <textarea name="description" id="description" rows="3" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="document" class="form-label">Ngarko dokumentin (opsionale)</label>
            <input type="file" name="document" id="document" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
        </div>

        <button type="submit" class="btn btn-primary">Rezervo Takimin</button>
    </form>
</div>

<script>
    document.getElementById('appointment_slot_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const start = selected.getAttribute('data-start');
        const end = selected.getAttribute('data-end');
        const timeSelect = document.getElementById('selected_time');

        timeSelect.innerHTML = '<option value="">Zgjidh orën</option>';

        if (start && end) {
            const startTime = new Date(`1970-01-01T${start}`);
            const endTime = new Date(`1970-01-01T${end}`);

            while (startTime < endTime) {
                const nextTime = new Date(startTime.getTime() + 30 * 60000); // 30 min interval
                const option = document.createElement('option');
                option.value = startTime.toTimeString().substring(0, 5);
                option.text = `${startTime.toTimeString().substring(0, 5)} - ${nextTime.toTimeString().substring(0, 5)}`;
                timeSelect.appendChild(option);
                startTime.setTime(nextTime);
            }
        }
    });
</script>
@endsection
