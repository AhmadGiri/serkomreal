<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Movie extends Model { protected $fillable=['title','genre','duration','synopsis','image']; public function schedules(){return $this->hasMany(Schedule::class);} }
