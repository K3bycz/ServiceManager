<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'start_date', 'end_date', 'color']; 

    public function getAllEvents()
    {
        return $this->all();
    }

    public function getEvent($id)
    {
        return $this->find($id); 
    }
}