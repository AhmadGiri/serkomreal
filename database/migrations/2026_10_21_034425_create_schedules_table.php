<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('schedules', function(Blueprint $table){$table->id();$table->foreignId('movie_id')->constrained()->cascadeOnDelete();$table->foreignId('ticket_price_id')->constrained('ticket_prices')->cascadeOnDelete();$table->dateTime('show_time');$table->string('studio');$table->timestamps();});} public function down(): void {Schema::dropIfExists('schedules');}};
