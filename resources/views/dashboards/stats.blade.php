@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('partials.dashboardMenu')
    <div class="dashboard-content">
        <div class="row">
            <div class="monthly-stats-container col-12 col-md-6">
                <canvas id="monthlyStatsChart" height="150"></canvas>
            </div>
            <div class="device-categories-container col-12 col-md-6">
                <canvas id="deviceCategoriesChart" height="140"></canvas>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-12 col-md-6 p-0" style="padding-right:10px !important">
                <div class="year-stats-container">
                    <canvas id="yearStatsChart" height="150"></canvas>
                </div>
            </div>
            <div class="col-12 col-md-6 p-0" style="padding-left:10px !important">
                <div class="new-customers-container">
                    <canvas id="customersChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const yearCtx = document.getElementById('yearStatsChart').getContext('2d');
        new Chart(yearCtx, {
            type: 'bar',
            data: {
                labels: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 
                        'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
                datasets: [
                    {
                        label: 'Naprawy przyjęte',
                        data: {{ json_encode($yearlyRepairs) }},
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Naprawy wydane',
                        data: {{ json_encode($yearlyEndedRepairs) }},
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
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
                            text: 'Liczba napraw'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Statystyki napraw w bieżącym roku - ' + new Date().getFullYear()
                    }
                }
            }
        });

        const monthCtx = document.getElementById('monthlyStatsChart').getContext('2d');
            new Chart(monthCtx, {
            type: 'bar',
            data: {
                labels: {{ json_encode($dailyLabels) }},
                datasets: [
                    {   
                        type: 'bar',
                        label: 'Naprawy przyjęte',
                        data: {{ json_encode($monthlyRepairs) }},
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {   
                        type: 'line',
                        label: 'Naprawy wydane',
                        data: {{ json_encode($monthlyEndedRepairs) }},
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 4,
                        pointRadius: 3,
                    }
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
                            text: 'Liczba napraw'
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
    });

    const categories = {!! json_encode($deviceCategories) !!};
    const counts = {!! json_encode($deviceCounts) !!};
    const newCustomers = {!! json_encode($newCustomers) !!};

    document.addEventListener('DOMContentLoaded', function() {
        const categoryCtx = document.getElementById('deviceCategoriesChart').getContext('2d');
        const deviceData = {
            labels: categories,
            datasets: [{
                data: counts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(199, 199, 199, 0.7)',
                    'rgba(83, 102, 255, 0.7)',
                    'rgba(255, 99, 255, 0.7)',
                    'rgba(255, 211, 99, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)',
                    'rgba(255, 99, 255, 1)',
                    'rgba(255, 211, 99, 1)'
                ],
                borderWidth: 1
            }]
        };
        
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: deviceData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Statystyki urządzeń przyjmowanych w bieżącym roku - ' + new Date().getFullYear()
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.formattedValue;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.raw / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });

    const customersCtx = document.getElementById('customersChart').getContext('2d');
    new Chart(customersCtx, {
        type: 'line',
        data: {
            labels: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 
                    'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
            datasets: [{
                label: 'Nowi klienci',
                data: newCustomers,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear',
                    from: 1,
                    to: 0,
                    loop: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Liczba klientów'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Nowi klienci w bieżącym roku - ' + new Date().getFullYear()
                }
            }
        }
    });
</script>

@endsection