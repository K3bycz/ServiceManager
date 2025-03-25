<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'category', 'manufacturer', 'model', 'serialNumber'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class, 'device');
    }

    public function getAllDevices()
    {
        return $this->all();
    }

    public function getDevice($id)
    {
        return $this->find($id); 
    }
}