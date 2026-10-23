<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class TicketPrice extends Model { protected $fillable=['category_day','price']; public function schedules(){return $this->hasMany(Schedule::class);} }
