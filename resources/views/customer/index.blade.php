<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket Bioskop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 font-sans">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Bioskop XXI - Jadwal Tayang & Pemesanan</h1>
            <p class="text-gray-500 text-sm mt-1">Pilih film favorit Anda, tentukan jumlah tiket, dan isi data diri.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 text-center font-semibold">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 text-center font-semibold">{{ session('error') }}</div>
        @endif

        <form action="{{ route('customer.checkout') }}" method="POST">
            @csrf
            <!-- Informasi Pemesan -->
            <div class="bg-white p-6 rounded-xl shadow-sm border mb-8">
                <h2 class="text-lg font-bold text-gray-700 mb-4 pb-2 border-b">1. Informasi Data Penonton</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="customer_name" required placeholder="Masukkan nama Anda" class="w-full border rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Email Aktif</label>
                        <input type="email" name="customer_email" required placeholder="email@domain.com" class="w-full border rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Pilih Jadwal Film -->
            <h2 class="text-lg font-bold text-gray-700 mb-4">2. Pilih Jadwal & Film</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach($schedules as $schedule)
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden flex flex-col justify-between">
                    <div>
                        @if($schedule->movie->image)
                            <img src="{{ asset('storage/' . $schedule->movie->image) }}" alt="{{ $schedule->movie->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="bg-gray-200 h-48 flex items-center justify-center text-gray-400 font-medium">Poster Tidak Tersedia</div>
                        @endif
                        <div class="p-4">
                            <span class="text-xs bg-indigo-100 text-indigo-700 font-semibold px-2.5 py-0.5 rounded">{{ $schedule->movie->genre }}</span>
                            <h3 class="font-bold text-gray-800 text-lg mt-2">{{ $schedule->movie->title }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Durasi: {{ $schedule->movie->duration }} Menit</p>
                            <p class="text-xs text-gray-600 mt-2"><strong>Studio:</strong> {{ $schedule->studio }} | <strong>Tayang:</strong> {{ $schedule->show_time }}</p>
                            <p class="text-sm font-bold text-green-600 mt-2">Kategori: {{ $schedule->ticketPrice->category_day }} (Rp {{ number_format($schedule->ticketPrice->price) }})</p>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 border-t">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah Tiket</label>
                        <input type="number" name="tickets[{{ $schedule->id }}]" min="0" value="0" class="w-full border rounded-lg px-3 py-1.5 text-center font-bold text-gray-700 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-md transition">Pesan Tiket Sekarang</button>
            </div>
        </form>
    </div>
</body>
</html>