@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(isset($title) && isset($client))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
    @endif
    <div class="form-container">
        <form class="row" method="POST" action="{{ route('clients.store') }}">
            @csrf
            @if (isset($client->id))
                <input type="hidden" name="id" value="{{ $client->id }}">
            @endif
            <div class="form-group col-6">
                <label for="name">Imie<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="name" id="name" value="{{ $client->name ?? '' }}">
            </div>
            <div class="form-group col-6">
                <label for="surname">Nazwisko<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="surname" id="surname" value="{{ $client->surname ?? '' }}">
            </div>
            <div class="form-group col-12">
                <label for="phoneNumber">Numer telefonu<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="phoneNumber" id="phoneNumber" value="{{ $client->phoneNumber ?? '' }}">
            </div>
            <div class="form-group col-12 text-end" style="padding-top:20px">
                <button type="submit" class="btn btn-custom" style="margin-bottom: 0px">Zapisz i zamknij</button>
            </div>
        </form>
    </div>

@endsection
