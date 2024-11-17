<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'phoneNumber'];

    public function devices()
    {
        return $this->hasMany(Device::class, 'owner');
    }

    public function getAllClients()
    {
        return $this->all();
    }

    public function getClient($id)
    {
        return $this->find($id);
    }
}
