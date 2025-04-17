@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/list.css') }}" rel="stylesheet">
@endsection

@section('content')
        <div id="notificationContainer"></div>
        <div class="list-title text-dark">
            @if(isset($title) && isset($data))
                <p style="font-size:25px; font-weight:bold; color:white">{{ $title }}</p>
            @endif
        </div>
        <div class="table-container">
            <div class="d-flex justify-content-between mb-3">
                <div class="table-button">
                    @if($type != "repair")
                        <a href="/{{ $type }}/create" class="btn btn-custom">Dodaj nowy</a>
                    @else
                        <button id="notificationButton" class="btn btn-custom">Dodaj nowy</button>
                    @endif
                </div>
                <div class="search-container mb-3">
                    <div class="search-wrapper position-relative">
                        <div class="search-input-group">
                            <button id="searchButton" class="search-icon">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <input type="text" id="searchInput" class="search-input" placeholder="Wyszukaj">
                        </div>
                        <a href="{{ request()->url() }}" class="search-clear-button">
                            <i class="fa-solid fa-x"></i>
                        </a>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped w-100 responsive-table" style="background-color:white">
                @if($data->isEmpty())
                    <p class="text-center">Brak danych do wyświetlenia</p>
                @else
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
                                <th>Klient</th>
                                <th>Kategoria</th>
                                <th>Numer seryjny</th>
                                <th class="actions-column">Akcje</th>
                            @elseif($data[0] instanceof App\Models\Repair)
                                <th>Numer naprawy</th>
                                <th>Status naprawy</th>
                                <th>Data przyjęcia</th>
                                <th>Data wydania</th>
                                <th>Tytuł naprawy</th>
                                <th>Przychód</th>
                                <th class="actions-column">Akcje</th>
                            @elseif($data[0] instanceof App\Models\Order)
                                <th style="width: 70%">Tytuł zamówienia</th>
                                <th>Status zamówienia</th>
                                <th>Hurtownia</th>
                                <th class="actions-column">Akcje</th>
                            @elseif($data[0] instanceof App\Models\Trip)
                                <th>Data wyjazdu</th>
                                <th>Adres</th>
                                <th>Opis czynności</th>
                                <th class="actions-column">Akcje</th>
                            @elseif($data[0] instanceof App\Models\Event)
                                <th>Tytuł wydarzenia</th>
                                <th>Data rozpoczęcia</th>
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
                                    <td class="editButtonRow"><a href="{{ '/client/' . $item->id . '/edit' }}" class="no-style-link"><i class="fa fa-pencil icon-square"></i></a></td>
                                @elseif($item instanceof App\Models\Device)
                                    <td>{{ $item->manufacturer }}</td>
                                    <td>{{ $item->model }}</td>
                                    <td>{{ $item->client ? $item->client->name . ' ' . $item->client->surname . ' (' . $item->client->phoneNumber . ')': 'Brak właściciela' }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->serialNumber }}</td>
                                    <td class="editButtonRow"><a href="{{ '/device/' . $item->id . '/edit' }}" class="no-style-link"><i class="fa fa-pencil icon-square"></i></a></td>
                                @elseif($item instanceof App\Models\Repair)
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->status->name ?? 'Brak statusu' }}</td>
                                    <td>{{ $item->date_received }}</td>
                                    <td>{{ $item->date_released}}</td>
                                    <td>{{ $item->title}}</td>
                                    <td>@if(isset($item->revenue)) {{ $item->revenue}} PLN @endif</td>
                                    <td class="editButtonRow"><a href="{{ '/repairs/'. $item->device_id . '/' . $item->id . '/edit' }}" class="no-style-link"><i class="fa fa-pencil icon-square"></i></a></td>
                                @elseif($data[0] instanceof App\Models\Order)
                                    <td>{{ $item->title }} @if(isset($item->repair_id) && $item->repair_id != null) | Naprawa: {{  $item->repair_id }}@endif</td>
                                    <td>{{ $item->status}}</td>
                                    <td>{{ $item->warehouse }}</td>
                                    <td class="editButtonRow"><a href="{{ '/order/'. $item->id . '/edit' }}" class="no-style-link"><i class="fa fa-pencil icon-square"></i></a></td>
                                @elseif($data[0] instanceof App\Models\Trip)
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td class="editButtonRow"><a href="{{ '/trip/'. $item->id . '/edit' }}" class="no-style-link"><i class="fa fa-pencil icon-square"></i></a></td>
                                @elseif($data[0] instanceof App\Models\Event)
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->start_date }}</td>
                                    <td class="editButtonRow"><a href="{{ '/event/'. $item->id . '/edit' }}" class="no-style-link"><i class="fa fa-pencil icon-square"></i></a></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
            @if(isset($data) && method_exists($data, 'links'))
                <div class="pagination-container d-flex justify-content-end" style="margin-top: 30px;">
                    {{ $data->links('vendor.pagination.bootstrap-5') }}                    
                </div>
            @endif
        </div>
  
@endsection

@section ('scripts')
    <script>
        document.getElementById('notificationButton').addEventListener('click', function () {
            const notificationContainer = document.getElementById('notificationContainer');

            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.innerText = 'Dodawaj naprawy poprzez zakładkę ,,Naprawy" z menu edycji urządzenia!';

            notificationContainer.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3500);
        });
        </script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            
            // Funkcja wyszukiwania
            function performSearch() {
                const searchValue = searchInput.value.trim();
                if (searchValue) {
                    // Zachowaj obecne parametry URL i dodaj/aktualizuj parametr search
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('search', searchValue);
                    window.location.href = currentUrl.toString();
                }
            }
            
            // Obsługa przycisku wyszukiwania
            searchButton.addEventListener('click', performSearch);
            
            // Obsługa wciśnięcia Enter w polu wyszukiwania
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
        });
    </script>
@endsection