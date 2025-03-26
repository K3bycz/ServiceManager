@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="dashboard-title">
        @if(isset($title))
            <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
        @endif
    </div>
    <div class="links-container">
        <a href="/" class="custom-link">Pulpit</a>
        <a href="/stats" class="custom-link">Statystyka</a>
    </div>

        @if(isset($currentRepairs))
            <div class="current-repairs-container">
                <table class="table table-bordered table-striped w-100 responsive-table dashboard-repairs-table" style="background-color:white; margin-bottom:0px;">
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
                                        {{ $repair->device->client->name }} {{ $repair->device->client->surname }} ({{ $repair->device->client->phoneNumber }})
                                    </td>
                                    <td>
                                        {{ $repair->device->category }} - {{ $repair->device->manufacturer }} ({{ $repair->device->model }})
                                    </td>
                                    <td>
                                        <b>{{ $repair->id }}</b> - {{ $repair->title }}
                                    </td>
                                    <td>
                                        {{ $repair->date_received }}
                                    </td>
                                    <td>
                                        {{ $repair->profit }} PLN
                                    </td>
                                    <td>
                                        <p style="font-weight:bold; border-radius:10px; padding:5px; margin:0px; background-color:{{ $repair->status->background_color }}; color:{{ $repair->status->text_color }}">{{ $repair->status->name }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        @endif
        
        @if(isset($endedRepairs))
            <div class="ended-repairs-container col-6 m-0">
                <table class="table table-bordered table-striped w-100 responsive-table dashboard-repairs-table" style="background-color:white; margin-bottom:0px;">
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
                                <tr @if($repair->profit <= 0 || $repair->profit == null) style="background-color:#e33b43" @endif>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <b>{{ $repair->id }}</b> - {{ $repair->title }}
                                    </td>
                                    <td>
                                        {{ $repair->date_received }}
                                    </td>
                                    <td>
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
