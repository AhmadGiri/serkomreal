<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OrderDetail extends Model {
     protected $fillable=['order_id','schedule_id','quantity','subtotal'];
      public function order()
      {return $this->belongsTo(Order::class);}
       public function schedule()
       {return $this->belongsTo(Schedule::class);}
        }
