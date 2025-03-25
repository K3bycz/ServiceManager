<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'text-color', 'background_color'];
 
    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }
}

