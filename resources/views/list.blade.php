@extends('layouts.app')

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
                        @elseif($data[0] instanceof App\Models\Device)
                            <th>Kategoria</th>
                            <th>Producent</th>
                            <th>Model</th>
                            <th>Numer seryjny</th>
                        @elseif($data[0] instanceof App\Models\Device)
                            <th>Tytuł Naprawy</th>
                            <th>Opis Naprawy</th>
                            <th>Profits</th>
                            <th>Koszty</th>
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
                            @elseif($item instanceof App\Models\Device)
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->manufacturer }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->serialNumber }}</td>
                            @elseif($item instanceof App\Models\Repair)
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->profits }} PLN</td>
                                <td>{{ $item->costs }} PLN</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
