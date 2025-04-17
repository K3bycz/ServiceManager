<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Trip;
use Carbon\Carbon;

class CalendarService{

    public function getAllCalendarItems(): array
    {
        $events = $this->getEvents();
        $trips = $this->getTrips();
        
        return array_merge($events, $trips);
    }

    private function getEvents(): array
    {
        $events = Event::all();
        
        return $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => Carbon::parse($event->end_date)->addDay()->format('Y-m-d'),
                'color' => $event->color,
                'allDay' => true,
                'type' => 'event',
            ];
        })->toArray();
    }
    
    private function getTrips(): array
    {
        $trips = Trip::all();
        
        return $trips->map(function ($trip) {
            return [
                'id' => $trip->id,
                'title' => $trip->address,
                'start' => $trip->date,
                'color' => '#8AC7AD',
                'allDay' => true,
                'type' => 'trip',
            ];
        })->toArray();
    }
}