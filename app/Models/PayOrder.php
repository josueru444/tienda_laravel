<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayOrder extends Model
{
    protected $table="pay_order";
    protected $fillable = ['id', 'total', 'file', 'observations', 'status', 'orders_id', 'user_id', 'created_at', 'updated_at'];
}
