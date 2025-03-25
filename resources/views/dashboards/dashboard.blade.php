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
    @if(isset($repairs))
        <div class="repairs-container">
            <table class="table table-bordered table-striped w-100 responsive-table" style="background-color:white">
                @if($repairs->isEmpty())
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
                        
                        @foreach ($repairs as $repair)
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
                                    {{ $repair->id }} - {{ $repair->title }}
                                </td>
                                <td>
                                    {{ $repair->date_received }}
                                </td>
                                <td>
                                    {{ $repair->profit }}
                                </td>
                                <td>
                                    {{ $repair->status }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    @endif
@endsection
