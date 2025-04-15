@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
        @include('partials.dashboardMenu')

        @if(isset($currentRepairs))
            <div class="current-repairs-container">
                <table class="table table-bordered table-striped w-100 responsive-table dashboard-repairs-table" style="background-color:white; margin-bottom:0px;">
                    <p class="text-center" style="font-family:'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; font-weight:bold; color:#666; font-size:14px; margin-bottom:20px;">
                        Obecne naprawy - {{ $currentMonth }} 
                    </p>
                    @if($currentRepairs->isEmpty())
                        <p class="text-center">Brak danych do wyświetlenia</p>
                    @else
                        <thead>
                            <tr>
                                <th>Nr</th>
                                <th>Klient</th>
                                <th>Sprzęt</th>
                                <th>Naprawa</th>
                                <th>Data przyjęcia</th>
                                <th>Szacowane</th>
                                <th>Status</th>
                            </tr>
                        </thead>    
                        <tbody>
                            @foreach ($currentRepairs as $repair)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <a href="/client/{{ $repair->device->client->id }}/edit" class="black-link">{{ $repair->device->client->name }} {{ $repair->device->client->surname }} ({{ $repair->device->client->phoneNumber }})</a>
                                    </td>
                                    <td>
                                        <a href="/device/{{ $repair->device->id }}/edit" class="black-link">{{ $repair->device->category }} - {{ $repair->device->manufacturer }} ({{ $repair->device->model }})</a>
                                    </td>
                                    <td>
                                        <a href="/repairs/{{ $repair->device->id }}/{{ $repair->id }}/edit" class="black-link"><b>{{ $repair->id }}</b> - {{ $repair->title }}</a>
                                    </td>
                                    <td>
                                        {{ $repair->date_received }}
                                    </td>
                                    <td>
                                        {{ $repair->profit }} PLN
                                    </td>
                                    <td>
                                        <p style="font-weight:bold; border-radius:10px; padding:3px; margin:0px; background-color:{{ $repair->status->background_color }}; color:{{ $repair->status->text_color }}">{{ $repair->status->name }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        @endif
        
        @if(isset($endedRepairs))
            <div class="ended-repairs-container col-12 col-md-6 m-0">
                <table class="table table-bordered table-striped w-100 responsive-table dashboard-repairs-table" style="background-color:white; margin-bottom:0px;">
                    <p class="text-center" style="font-family:'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; font-weight:bold; color:#666; font-size:14px; margin-bottom:20px;">
                        Zakończone naprawy - {{ $currentMonth }} 
                    </p>
                    @if($endedRepairs->isEmpty())
                        <p class="text-center">Brak danych do wyświetlenia</p>
                    @else
                        <thead>
                            <tr>
                                <th>Nr</th>
                                <th>Naprawa</th>
                                <th>Data wydania</th>
                                <th>Zarobek</th>
                            </tr>
                        </thead>    
                        <tbody>
                            @foreach ($endedRepairs as $repair)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <a href="/repairs/{{ $repair->device->id }}/{{ $repair->id }}/edit" class="black-link"><b>{{ $repair->id }}</b> - {{ $repair->title }}</a>
                                    </td>
                                    <td>
                                        {{ $repair->date_received }}
                                    </td>
                                    <td @if($repair->profit <= 0 || $repair->profit == null) style="color:#e33b43" @endif>
                                        {{ $repair->profit }} PLN
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        @endif
    <div>
@endsection
