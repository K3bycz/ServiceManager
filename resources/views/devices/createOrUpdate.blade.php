@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="notificationContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>
    @if(isset($title) && isset($device))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
        <div class="menu-form-container pink-hover">
            <a href="{{ '/device/' . $device->id . '/edit' }}" class="text-decoration-none menu-option">Dane sprzętu</a>
            <a href="{{ '/device/' . $device->id . '/repairs' }}" class="text-decoration-none menu-option">Naprawy</a>
        </div>
        <div class="form-container" style="border-radius: 0 0 10px 10px;">
    @else
        <div class="form-container">
    @endif
        <form class="row" method="POST" action="{{ route('devices.store') }}">
            @csrf
            <div class="form-group col-12 position-relative">
                <label for="owner">Klient<span style="color:red; padding:0px;">*</span></label>
                <input type="text" class="form-control" name="owner" id="owner" value="@if(isset($device->client)){{ $device->client->name }} {{ $device->client->surname }} ({{ $device->client->phoneNumber }})@else{{ '' }}@endif" autocomplete="off">
                <input type="hidden" name="owner_id" id="owner_id" value ="{{ $device->owner ?? '' }}">
                @if (isset($device->id))
                    <input type="hidden" name="id" value="{{ $device->id }}">
                @endif
                <ul id="owner-suggestions" style="display: none;"></ul>
            </div>
            <div class="form-group col-6" style="margin-top:25px;">
                <label for="category">Kategoria<span style="color:red; padding:0px;">*<span></label>
                <input list="categories" class="form-control form-input" name="category" id="category" value="{{ $device->category ?? '' }}" required>
                <datalist id="categories">
                    <option value="Laptop">
                    <option value="Komputer">
                    <option value="Drukarka">
                    <option value="Konsola do gier">
                    <option value="Tablet">
                    <option value="Smartfon">
                    <option value="inne">
                </datalist>
            </div>
            <div class="form-group col-6" style="margin-top:25px;">
                <label for="manufacturer">Producent<span style="color:red; padding:0px;">*<span></label>
                <input list="manufacturers" class="form-control form-input" name="manufacturer" id="manufacturer" value="{{ $device->manufacturer ?? '' }}" required>
                <datalist id="manufacturers">
                    <option value="HP">
                    <option value="Asus">
                    <option value="Acer">
                    <option value="Lenovo">
                    <option value="Dell">
                    <option value="Epson">
                    <option value="Canon">
                    <option value="Apple">
                </datalist>
            </div>
            <div class="form-group col-6">
                <label for="model">Model</label>
                <input type="text" class="form-control form-input" name="model" id="model" value="{{ $device->model ?? '' }}">
            </div>
            <div class="form-group col-6">
                <label for="serialNumber">Numer seryjny</label>
                <input type="text" class="form-control form-input" name="serialNumber" id="serialNumber" value="{{ $device->serialNumber ?? '' }}">
            </div>
            <div class="form-group col-12 text-end" style="padding-top:20px">
                <button type="submit" class="btn btn-custom" name="action" value="save" style="margin-bottom: 0px">Zapisz</button>
                <button type="submit" class="btn btn-custom" name="action" value="save_and_close" style="margin-bottom: 0px">Zapisz i zamknij</button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ownerInput = document.getElementById('owner');
        const ownerIdInput = document.getElementById('owner_id');
        const suggestionsBox = document.getElementById('owner-suggestions');

        ownerInput.addEventListener('input', function () {
            const query = ownerInput.value.trim();

            if (query.length > 0) {
                fetch(`/clients/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(clients => {
                        suggestionsBox.innerHTML = '';
                        if (clients.length > 0) {
                            suggestionsBox.style.display = 'block';
                            clients.forEach(client => {
                                const li = document.createElement('li');
                                li.classList.add('list-group-item');
                                li.textContent = `${client.name} ${client.surname} (${client.phoneNumber})`;
                                li.addEventListener('click', () => {
                                    ownerInput.value = `${client.name} ${client.surname} (${client.phoneNumber})`;
                                    ownerIdInput.value = client.id;
                                    suggestionsBox.style.display = 'none';
                                });
                                suggestionsBox.appendChild(li);
                            });
                        } else {
                            suggestionsBox.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Błąd podczas wyszukiwania klientów:', error));
            } else {
                suggestionsBox.style.display = 'none';
            }
        });

        document.addEventListener('click', function (e) {
            if (!suggestionsBox.contains(e.target) && e.target !== ownerInput) {
                suggestionsBox.style.display = 'none';
            }
        });
    });
</script>
@endsection