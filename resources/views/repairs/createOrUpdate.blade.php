@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if($repair==null && isset($title))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
    @elseif(!$repair==null && isset($title))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }} nr.{{ $repair->id }}</p>
    @endif
    <div class="info-form-container">
        <div class="row">
            <div class="col-4 mb-3">
                <p style="margin-bottom:10px">Klient:</p>
                <h3>{{$client->name}} {{$client->surname}}</h3>
                <p class="m-0" style="color:grey">Tel: {{$client->phoneNumber}}</p>
            </div>
            <div class="col-4 mb-3">
                <p style="margin-bottom:10px">Sprzęt:</p>
                <h3> {{$device->category}} </h3>
                <p class="m-0" style="color:grey">Producent: {{$device->manufacturer}}</p>
                @if(isset($device->model))<p class="m-0" style="color:grey">Model: {{$device->model}}</p>@endif
                @if(isset($device->serialNumber))<p class="m-0" style="color:grey">Numer Seryjny: {{$device->serialNumber}}</p>@endif
            </div>
        </div>
    </div>
    <div class="form-container" style="border-radius: 0 0 10px 10px;">
        <form class="row" method="POST" action="{{ route('repairs.store') }}">
            @csrf
            <div class="col-3 form-group">
                <label for="number">Numer naprawy</label>
                <input type="text" class="form-control form-input" name="number" id="number" value="@if(isset($repair->id)){{ $repair->id }}@endif" disabled>
            </div>
            <input type="hidden" name="device" id="device" value ="{{ $device->id }}">
            <div class="col-3 form-group">
                <label for="status">Status naprawy</label>
                <select id="status" name="status" class="form-control">
                    <option value="option1">Nowa</option>
                    <option value="option2">W trakcie realizacji</option>
                    <option value="option3">Gotowa do wydania</option>
                    <option value="option3">Zakończona</option>
                    <option value="option3">Oczekuje na części</option>
                    <option value="option3">Oczekuje na klienta</option>
                </select>
            </div>
            <div class="col-3 form-group">
                <label for="date_received">Data przyjęcia</label>
                <input type="date" class="form-control form-input" name="date_received" id="date_received" value="@if(isset($repair->date_received)){{ $repair->date_received }}@endif">
            </div>
            <div class="col-3 form-group">
                <label for="date_released">Data wydania</label>
                <input type="date" class="form-control form-input" name="date_released" id="date_released" value="@if(isset($repair->date_released)){{ $repair->date_released }}@endif">
            </div>
            <div class="col-12 form-group">
                <label for="title">Tytuł naprawy</label>
                <input type="text" class="form-control form-input" name="title" id="title" value="@if(isset($repair->title)){{ $repair->title }}@endif">
            </div>
            <div class="col-12 form-group">
                <label for="description">Opis naprawy</label>
                <textarea name="description" id="description" class="form-control form-input" value="@if(isset($repair->title)){{ $repair->title }}@endif"></textarea>
            </div>
            <div class="col-6 form-group">
                <label for="costs">Koszta</label>
                <input type="text" class="form-control form-input" name="costs" id="costs" value="@if(isset($repair->costs)){{ $repair->costs }}@endif">
            </div>
            <div class="col-6 form-group">
                <label for="revenue">Przychody</label>
                <input type="text" class="form-control form-input" name="revenue" id="revenue" value="@if(isset($repair->revenue)){{ $repair->revenue }}@endif">
            </div>
            <div class="form-group col-12 text-end" style="padding-top:20px">
                <button type="submit" class="btn btn-custom" style="margin-bottom: 0px">Zapisz i zamknij</button>
            </div>
        </form>
    </div>

@endsection