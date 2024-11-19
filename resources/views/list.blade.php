@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/list.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if($data->isEmpty())
        <p class="text-left">Brak danych do wyświetlenia</p>
    @else
        <div class="list-title text-dark">
            @if(isset($title) && isset($data))
                <p style="font-size:18px; font-weight:bold; color:white">{{ $title }}</p>
            @endif
        </div>
        <div class="table-container" style="height: 100%;">
            <table class="table table-bordered table-striped w-100" style="background-color:white">
                <thead>
                    <tr>
                        @if($data[0] instanceof App\Models\Client)
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Numer telefonu</th>
                            <th class="actions-column">Akcje</th>
                        @elseif($data[0] instanceof App\Models\Device)
                            <th>Producent</th>
                            <th>Model</th>
                            <th>Kategoria</th>
                            <th>Numer seryjny</th>
                            <th class="actions-column">Akcje</th>
                        @elseif($data[0] instanceof App\Models\Device)
                            <th>Tytuł Naprawy</th>
                            <th>Opis Naprawy</th>
                            <th>Profits</th>
                            <th>Koszty</th>
                            <th class="actions-column">Akcje</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            @if($item instanceof App\Models\Client)
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->surname }}</td>
                                <td>{{ $item->phoneNumber }}</td>
                                <td><i class="fa fa-pencil icon-square"></i></td>
                            @elseif($item instanceof App\Models\Device)
                                <td>{{ $item->manufacturer }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->serialNumber }}</td>
                                <td><i class="fa fa-pencil icon-square"></i></td>
                            @elseif($item instanceof App\Models\Repair)
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->profits }} PLN</td>
                                <td>{{ $item->costs }} PLN</td>
                                <td><i class="fa fa-pencil icon-square"></i></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
