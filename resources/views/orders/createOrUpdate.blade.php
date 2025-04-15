@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="notificationContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>
    @if(isset($title) && isset($order))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
    @endif
    <div class="form-container">
        <form class="row" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="form-group col-12 col-md-8 position-relative">
                <label for="title">Nazwa zamówienia<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="title" id="title" value="{{ $order->title ?? '' }}" required>
                @if (isset($order->id))
                    <input type="hidden" name="id" value="{{ $order->id }}">
                @endif
            </div>
            <div class="form-group col-12 col-md-4 position-relative">
                <label for="repair_id">Numer naprawy</label>
                <input type="number" class="form-control form-input" name="repair_id" id="repair_id" value="{{ $order->repair_id ?? '' }}">
            </div>
            <div class="form-group col-12 position-relative">
                <label for="link">Link<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="link" id="link" value="{{ $order->link ?? '' }}" required>
            </div>
            <div class="form-group col-12 position-relative">
                <label for="warehouse">Hurtownia<span style="color:red; padding:0px;">*<span></label>
                <input type="text" class="form-control form-input" name="warehouse" id="warehouse" value="{{ $order->warehouse ?? '' }}" required>
            </div>
            <div class="form-group col-12">
                <label for="status">Status zamówienia<span style="color:red; padding:0px;">*<span></label>
                <select class="form-control form-input" name="status" id="status" required>
                    <option value="" disabled {{ empty($order->status) ? 'selected' : '' }}>Wybierz status</option>
                    <option value="Do zamówienia" {{ ($order->status ?? '') == 'Do zamówienia' ? 'selected' : '' }}>Do zamówienia</option>
                    <option value="Zamówione" {{ ($order->status ?? '') == 'Zamówione' ? 'selected' : '' }}>Zamówione</option>
                    <option value="Odebrane" {{ ($order->status ?? '') == 'Odebrane' ? 'selected' : '' }}>Odebrane</option>
                </select>
            </div>
           
            <div class="form-group col-12 text-end" style="padding-top:20px">
                <button type="submit" class="btn btn-custom" name="action" value="save" style="margin-bottom: 0px">Zapisz</button>
                <button type="submit" class="btn btn-custom" name="action" value="save_and_close" style="margin-bottom: 0px">Zapisz i zamknij</button>
            </div>
        </form>
    </div>
@endsection