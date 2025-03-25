@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="notificationContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>
    @if($repair==null && isset($title))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
    @elseif(!$repair==null && isset($title))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }} nr.{{ $repair->id }}</p>
    @endif
    <div class="info-form-container">
        <div class="row">
            <div class="col-6 col-md-4 mb-3">
                <p style="margin-bottom:10px">Klient:</p>
                <h3 class="pink-hover">
                <a href="{{ url('client/' . $client->id . '/edit') }}" style="text-decoration: none; color:black;">{{ $client->name }} {{ $client->surname }}</a>
                </h3>
                <p class="m-0" style="color:grey">Tel: {{$client->phoneNumber}}</p>
            </div>
            <div class="col-6 col-md-4 mb-3">
                <p style="margin-bottom:10px">Sprzęt:</p>
                <h3 class="pink-hover"> 
                <a href="{{ url('device/' . $device->id . '/edit') }}" style="text-decoration: none; color:black;">{{$device->category}}</a>
                </h3>
                <p class="m-0" style="color:grey">Producent: {{$device->manufacturer}}</p>
                @if(isset($device->model))<p class="m-0" style="color:grey">Model: {{$device->model}}</p>@endif
                @if(isset($device->serialNumber))<p class="m-0" style="color:grey">Numer Seryjny: {{$device->serialNumber}}</p>@endif
            </div>
        </div>
    </div>
    <div class="form-container" style="border-radius: 0 0 10px 10px;">
        <form class="row" method="POST" action="{{ route('repairs.store') }}">
            @csrf
            <div class="col-6 col-md-3 form-group">
                <label for="number">Numer naprawy</label>
                <input type="text" class="form-control form-input" name="number" id="number" value="@if(isset($repair->id)){{ $repair->id }}@endif" disabled>
            </div>
            <input type="hidden" name="device_id" id="device_id" value ="{{ $device->id }}">
            <input type="hidden" name="id" id="id" value ="@if(isset($repair->id)){{ $repair->id }}@endif">
            <div class="col-6 col-md-3 form-group">
                <label for="status">Status naprawy</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="Nowa" @if(isset($repair) && $repair->status == 'Nowa') selected @endif>Nowa</option>
                    <option value="W trakcie realizacji" @if(isset($repair) && $repair->status == 'W trakcie realizacji') selected @endif>W trakcie realizacji</option>
                    <option value="Gotowa do wydania" @if(isset($repair) && $repair->status == 'Gotowa do wydania') selected @endif>Gotowa do wydania</option>
                    <option value="Zakończona" @if(isset($repair) && $repair->status == 'Zakończona') selected @endif>Zakończona</option>
                    <option value="Oczekuje na części" @if(isset($repair) && $repair->status == 'Oczekuje na części') selected @endif>Oczekuje na części</option>
                    <option value="Oczekuje na klienta" @if(isset($repair) && $repair->status == 'Oczekuje na klienta') selected @endif>Oczekuje na klienta</option>
                </select>
            </div>
            <div class="col-12 col-md-3 form-group">
                <label for="date_received">Data przyjęcia</label>
                <input type="date" class="form-control form-input" name="date_received" id="date_received" value="@if(isset($repair->date_received)){{ $repair->date_received }}@endif" required>
            </div>
            <div class="col-12 col-md-3 form-group">
                <label for="date_released">Data wydania</label>
                <input type="date" class="form-control form-input" name="date_released" id="date_released" value="@if(isset($repair->date_released)){{ $repair->date_released }}@endif">
            </div>
            <div class="col-12 form-group">
                <label for="title">Tytuł naprawy</label>
                <input type="text" class="form-control form-input" name="title" id="title" value="@if(isset($repair->title)){{ $repair->title }}@endif" required>
            </div>
            <div class="col-12 form-group">
                <label for="description">Opis naprawy</label>
                <textarea name="description" id="description" class="form-control form-input">@if(isset($repair->description)){{ $repair->description }}@endif</textarea>
            </div>
            <div class="col-6 col-md-4 form-group">
                <label for="costs">Koszta</label>
                <input type="text" class="form-control form-input" name="costs" id="costs" value="@if(isset($repair->costs)){{ $repair->costs }}@endif">
            </div>
            <div class="col-6 col-md-4 form-group">
                <label for="revenue">Przychody</label>
                <input type="text" class="form-control form-input" name="revenue" id="revenue" value="@if(isset($repair->revenue)){{ $repair->revenue }}@endif">
            </div>
            <div class="col-12 col-md-4 form-group">
                <label for="profit">Zarobek</label>
                <input type="text" class="form-control form-input" name="profit" id="profit" value="@if(isset($repair->profit)){{ $repair->profit }}@endif" disabled>
            </div>
            <div class="form-group col-12 text-end" style="padding-top:20px">
                <button type="submit" class="btn btn-custom" name="action" value="save" style="margin-bottom: 0px">Zapisz</button>
                <button type="submit" class="btn btn-custom" name="action" value="save_and_close" style="margin-bottom: 0px">Zapisz i zamknij</button>
            </div>
        </form>
    </div>

@endsection