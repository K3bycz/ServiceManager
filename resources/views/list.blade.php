<h1>{{ $title }}</h1>
@if($items->isEmpty())
    <p>Brak danych do wyświetlenia</p>
@else
    <ul>
        
        @foreach ($items as $item)         
            @if($item instanceof App\Models\Clients)
                <li> 
                    {{ $item->name }} {{ $item->surname }} 
                </li>
                <li> 
                    tel: {{ $item->phoneNumber }}
                </li>
            @elseif($item instanceof App\Models\Devices)
                <li> 
                    {{ $item->manufacturer }} {{ $item->model }} 
                </li>
                <li>
                    {{ $item->serialNumber}}
                </li>
            @elseif($item instanceof App\Models\Repairs)
                <li>
                    {{ $item->title }}
                </li>
                <li>
                    {{ $item->description }}
                </li>
                <li>   
                    Zarobek: {{ $item->profits }}PLN  Koszta:{{ $item->costs }}PLN 
                </li>
            @endif
           
        @endforeach
    </ul>
@endif
