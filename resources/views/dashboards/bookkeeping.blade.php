@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
        @include('partials.dashboardMenu')

        @if(isset($summaryStats))
            <div class="chart-container justify-content-center" style="height: fit-content; font-size:15x;  border-radius: 0px 0px 15px 15px">
                <p style="text-align:center"> {{ $currentMonth }} </p>
                <table style="width: 100%; border-collapse: collapse; margin-bottom:20px;">
                    <tr>
                        <td rowspan="2" style="padding: 10px; border: 1px solid #ddd; font-size:20px; text-align:center">Zarobek: <b>@if($summaryStats->total_profit == null) 0 @else {{$summaryStats->total_profit}}@endif PLN </b></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">Koszta: @if($summaryStats->total_costs == null) 0 @else{{$summaryStats->total_costs}}@endif PLN</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">Przychód: @if($summaryStats->total_revenue == null) 0 @else {{$summaryStats->total_revenue}}@endif PLN</td>
                    </tr>
                </table>
            </div> 
            <div class="row" style="margin-top: 20px; height: fit-content;">
                <div class="col-12 col-md-6 justify-content-center responsive-container" style="padding-left:0px;">
                    <div class="chart-container">
                        <canvas id="dailyProfitChart" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class="col-12 col-md-6 justify-content-center responsive-container" style="padding-right:0px;">
                    <div class="chart-container">
                        <canvas id="yearlyChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        @endif
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const profitCtx = document.getElementById('dailyProfitChart').getContext('2d');
            new Chart(profitCtx, {
            type: 'bar',
            data: {
                labels: {{ json_encode($dailyLabels) }},
                datasets: [
                    {   
                        type: 'bar',
                        label: 'Zarobek (PLN)',
                        data: {{ json_encode($dailyProfits) }},
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                        },
                        title: {
                            display: true,
                            text: 'Zarobek'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Dzień miesiąca'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Statystyki napraw w bieżącym miesiącu - ' + new Date().toLocaleString('pl-PL', { month: 'long' })
                    }
                }
            }
        });

        const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
        const chart = new Chart(yearlyCtx, {
            type: 'line',
            data: {
                labels: @json($monthNames),
                datasets: [
                    {
                        label: 'Przychody',
                        data: @json($monthlyRevenues),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: false,
                        tension: 0.1
                    },
                    {
                        label: 'Koszty',
                        data: @json($monthlyCosts),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: true,
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Kwota (PLN)'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Statystyki finansowe - rok ' + new Date().getFullYear()
                    }
                }
            }
        });
    </script>
@endsection