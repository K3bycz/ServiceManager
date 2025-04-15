<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['repair_id', 'title', 'link', 'status', 'warehouse'];

    public function getAllOrders()
    {
        return $this->all();
    }

    public function getOrder($id)
    {
        return $this->find($id); 
    }
}