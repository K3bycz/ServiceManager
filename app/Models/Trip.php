<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'address', 'date']; 

    public function getAllTrips()
    {
        return $this->all();
    }

    public function getTrip($id)
    {
        return $this->find($id); 
    }
}