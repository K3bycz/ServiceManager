@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <link href="{{ asset('css/list.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(isset($title) && isset($device))
        <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
        <div class="menu-form-container pink-hover">
            <a href="{{ '/device/' . $device->id . '/edit' }}" class="text-decoration-none menu-option">Dane sprzętu</a>
            <a href="{{ '/device/' . $device->id . '/repairs' }}" class="text-decoration-none menu-option">Naprawy</a>
        </div>
    @endif
    <div class="form-container" style="border-radius: 0 0 10px 10px;">
        <div class="d-flex justify-content-between mb-3">
            <div class="table-button">
                <a href="{{ route('repairs.create', ['deviceId' => $device->id]) }}" class="btn btn-custom">Dodaj nowy</a>
            </div>
            @if(isset($repairs) && method_exists($repairs, 'links'))
                <div class="pagination-container">
                    {{ $repairs->links('vendor.pagination.bootstrap-5') }}                    
                </div>
            @endif
        </div>
        <table class="table table-bordered table-striped w-100" style="background-color:white">
            @if($repairs->isEmpty())
                <p class="text-center">Brak danych do wyświetlenia</p>
            @else
                <thead>
                    <tr>
                        <th>Numer naprawy</th>
                        <th>Status naprawy</th>
                        <th>Data przyjęcia</th>
                        <th>Data wydania</th>
                        <th>Tytuł naprawy</th>
                        <th>Przychód</th>
                        <th class="actions-column">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($repairs as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->date_received }}</td>
                            <td>{{ $item->date_released }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->revenue }}</td>
                            <td><a href="{{ '/repairs/'. $item->device . '/' . $item->id . '/edit' }}" class="no-style-link"><i class="fa fa-pencil icon-square"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
    </div> 
@endsection
