<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = ['device', 'title', 'description', 'costs', 'revenue', 'profit', 'date_received', 'date_released', 'status' ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device');
    }

    public function getAllRepairs()
    {
        return $this->all();
    }

    public function getRepair($id)
    {
        return $this->find($id); 
    }
}