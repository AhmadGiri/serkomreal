<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Schedule extends Model { protected $fillable=['movie_id','ticket_price_id','show_time','studio']; public function movie(){return $this->belongsTo(Movie::class);} public function ticketPrice(){return $this->belongsTo(TicketPrice::class);} public function orderDetails(){return $this->hasMany(OrderDetail::class);} }
