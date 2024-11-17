<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = ['device', 'title', 'description', 'costs', 'profit'];

    public function device()
    {
        return $this->belongsTo(Devices::class, 'device');
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
