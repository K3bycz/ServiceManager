@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="notificationContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>
    @if(isset($title) && isset($trip))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
    @endif
    <div class="form-container" style="padding: 25px;">
        <form class="row" method="POST" action="{{ route('trips.store') }}">
            @csrf
            <div class="form-group col-12 col-md-6 position-relative">
                <label for="address">Adres (cel wyjazdu)<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input mb-0" name="address" id="address" value="{{ $trip->address ?? '' }}" required>
                <p style="font-size:11px; color:#a19f9f">format: ulica numer domu, kod pocztowy miejscowość</p>
                @if (isset($trip->id))
                    <input type="hidden" name="id" value="{{ $trip->id }}">
                @endif
            </div>
            <div class="form-group col-12 col-md-6 position-relative">
                <label for="date">Data wyjazdu<span style="color:red; padding:0px;">*<span></label>
                <input type="date" class="form-control form-input" name="date" id="date" value="{{ $trip->date ?? '' }}" required>
            </div>
            <div class="form-group col-12 position-relative">
                <label for="description">Opis czynności<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="description" id="description" value="{{ $trip->description ?? '' }}" required>
            </div>
           
            <div class="form-group col-12 text-end">
                <button type="submit" class="btn btn-custom" name="action" value="save" style="margin-bottom: 0px">Zapisz</button>
                <button type="submit" class="btn btn-custom" name="action" value="save_and_close" style="margin-bottom: 0px">Zapisz i zamknij</button>
            </div>
        </form>
    </div>
    @if (isset($trip) && $trip->address != null)
    <div class="form-container mt-3">
        <div class="map-container">
            <iframe 
                width="100%" 
                height="450" 
                frameborder="0" 
                scrolling="no" 
                marginheight="0" 
                marginwidth="0" 
                src="{{ $mapUrl }}">
            </iframe>
        </div>
    </div>
    @endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addressInput = document.getElementById('address');
    const addressError = document.getElementById('addressError');
    const form = addressInput.closest('form');
    
    const addressRegex = /^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+ [0-9a-zA-Z\/-]+, \d{2}-\d{3} [a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$/;
    
    form.addEventListener('submit', function(event) {
        const address = addressInput.value.trim();
        
        if (!addressRegex.test(address)) {
            event.preventDefault();
            addressInput.classList.add('is-invalid');
            addressError.style.display = 'block';
        }
    });
});
</script>
@endsection