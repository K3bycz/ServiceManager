<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'title', 'description', 'costs', 'revenue', 'profit', 'date_received', 'date_released', 'status_id' ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function status()
    {
        return $this->belongsTo(RepairStatus::class, 'status_id');
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