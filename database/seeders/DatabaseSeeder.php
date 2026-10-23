<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Movie;
use App\Models\TicketPrice;
use App\Models\Schedule;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bioskop.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
                'email_verified_at' => now()
            ]
        );

        $prices = [];

        foreach ([['Weekday', 35000], ['Weekend', 50000]] as [$c, $v]) {
            $prices[] = TicketPrice::firstOrCreate(
                ['category_day' => $c],
                ['price' => $v]
            );
        }

        $titles = [
            ['Dunia Baru', 'Sci-Fi'],
            ['Petualangan Senja', 'Adventure'],
            ['Misteri Kota', 'Mystery'],
            ['Langit Merah', 'Drama'],
            ['Pahlawan Terakhir', 'Action'],
            ['Rumah Tua', 'Horror'],
            ['Cinta Pertama', 'Romance'],
            ['Galaksi Jauh', 'Sci-Fi'],
            ['Operasi Rahasia', 'Action'],
            ['Hutan Ajaib', 'Fantasy'],
            ['Jejak Waktu', 'Sci-Fi'],
            ['Komedi Kampung', 'Comedy'],
            ['Bayangan Malam', 'Thriller'],
            ['Samudra Biru', 'Adventure'],
            ['Hari Esok', 'Drama']
        ];

        foreach ($titles as $i => [$title, $genre]) {
            $m = Movie::firstOrCreate(
                ['title' => $title],
                [
                    'genre' => $genre,
                    'duration' => 100 + ($i % 5) * 10,
                    'synopsis' => 'Film dummy untuk pengujian aplikasi pemesanan tiket.'
                ]
            );

            Schedule::firstOrCreate(
                [
                    'movie_id' => $m->id,
                    'show_time' => Carbon::tomorrow()->setTime(12 + ($i % 6), 0)
                ],
                [
                    'ticket_price_id' => $prices[$i % 2]->id,
                    'studio' => 'Studio ' . (($i % 4) + 1)
                ]
            );

            Customer::firstOrCreate(
                ['email' => 'penonton' . ($i + 1) . '@example.com'],
                [
                    'name' => 'Penonton ' . ($i + 1),
                    'phone' => '0812345678' . str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                    'address' => 'Alamat dummy ' . ($i + 1)
                ]
            );
        }
    }
}
