@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(isset($title) && isset($device))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
    @endif
    <div class="form-container">
        Under construction  ...
    </div>

@endsection