<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Order extends Model { protected $fillable=['customer_name','customer_email','total_price','status']; public function orderDetails(){return $this->hasMany(OrderDetail::class);} }
