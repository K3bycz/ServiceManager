@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(isset($title) && isset($device))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
    @endif
    <div class="form-container">
        <form class="row">
            <div class="form-group col-12">
                <label for="owner">Wlasciciel<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="owner" id="owner" value="">
            </div>
            <div class="form-group col-6">
                <label for="category">Kategoria<span style="color:red; padding:0px;">*<span></label>
                <input list="categories" class="form-control form-input" name="category" id="category" value="{{ $device->category ?? '' }}">
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
            <div class="form-group col-6">
                <label for="manufacturer">Producent<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="manufacturer" id="manufacturer" value="{{ $device->manufacturer ?? '' }}">
            </div>
            <div class="form-group col-6">
                <label for="serialNumber">Numer seryjny</label>
                <input type="text" class="form-control form-input" name="serialNumber" id="serialNumber" value="{{ $device->serialNumber ?? '' }}">
            </div>
            <div class="form-group col-6">
                <label for="model">Model</label>
                <input type="text" class="form-control form-input" name="model" id="model" value="{{ $device->model ?? '' }}">
            </div>
            <div class="form-group col-12 text-end" style="padding-top:20px">
                <button type="submit" class="btn btn-custom" style="margin-bottom: 0px">Zapisz i zamknij</button>
            </div>
        </form>
    </div>

@endsection