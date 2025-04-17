@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="notificationContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>
    @if(isset($title) && isset($trip))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
    @endif
    <div class="form-container">
        <form class="row" method="POST" action="{{ route('events.store') }}">
            @csrf
            <div class="form-group col-12 position-relative">
                <label for="title">Tytuł wydarzenia<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="title" id="title" value="{{ $event->title ?? '' }}" required>
                @if (isset($event->id))
                    <input type="hidden" name="id" value="{{ $event->id }}">
                @endif
            </div>
            <div class="form-group col-12 col-md-6 position-relative">
                <label for="start_date">Data rozpoczęcia<span style="color:red; padding:0px;">*<span></label>
                <input type="date" class="form-control form-input" name="start_date" id="start_date" value="{{ $event->start_date ?? '' }}" required>
            </div>
            <div class="form-group col-12 col-md-6 position-relative">
                <label for="end_date">Data zakończenia<span style="color:red; padding:0px;">*<span></label>
                <input type="date" class="form-control form-input" name="end_date" id="end_date" value="{{ $event->end_date ?? '' }}" required>
            </div>
            <div class="form-group col-12 col-md-6 position-relative">
                <label for="color">Kolor tła<span style="color:red; padding:0px;">*<span></label>
                <input type="color" class="form-control form-input" name="color" id="color" value="{{ $event->color ?? '' }}" required>
            </div>

            <div class="form-group col-12 text-end" style="padding-top:20px">
                <button type="submit" class="btn btn-custom" name="action" value="save" style="margin-bottom: 0px">Zapisz</button>
                <button type="submit" class="btn btn-custom" name="action" value="save_and_close" style="margin-bottom: 0px">Zapisz i zamknij</button>
            </div>
        </form>
    </div>
@endsection