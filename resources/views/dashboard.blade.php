
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between gap-3">
            <h2 class="font-semibold text-xl">
                Laporan Pemesanan Bioskop
            </h2>

            <div class="flex gap-2">
                <a
                    class="bg-indigo-600 text-white px-3 py-2 rounded"
                    href="{{ route('movies.index') }}"
                >
                    Film
                </a>

                <a
                    class="bg-green-600 text-white px-3 py-2 rounded"
                    href="{{ route('ticket-prices.index') }}"
                >
                    Harga Tiket
                </a>

                <a
                    class="bg-blue-600 text-white px-3 py-2 rounded"
                    href="{{ route('schedules.index') }}"
                >
                    Jadwal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        @if (session('success'))
            <p class="bg-green-100 p-3 mb-4">
                {{ session('success') }}
            </p>
        @endif

        <form
            class="bg-white p-4 mb-4 flex flex-wrap gap-3 items-end"
            method="GET"
        >
            <div>
                <label class="block">Dari tanggal</label>
                <input
                    class="border p-2 rounded"
                    type="date"
                    name="from"
                    value="{{ request('from') }}"
                >
            </div>

            <div>
                <label class="block">Sampai tanggal</label>
                <input
                    class="border p-2 rounded"
                    type="date"
                    name="to"
                    value="{{ request('to') }}"
                >
            </div>

            <button class="bg-gray-800 text-white px-4 py-2 rounded">
                Filter Laporan
            </button>

            <a
                class="px-4 py-2"
                href="{{ route('admin.dashboard') }}"
            >
                Reset
            </a>
        </form>

        <div class="bg-white overflow-x-auto p-4 rounded">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">ID</th>
                        <th>Penonton</th>
                        <th>Email</th>
                        <th>Rincian Tiket</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Ubah Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $o)
                        <tr class="border-t align-top">
                            <td class="p-3">
                                #{{ $o->id }}
                            </td>

                            <td>
                                {{ $o->customer_name }}
                            </td>

                            <td>
                                {{ $o->customer_email }}
                            </td>

                            <td>
                                @foreach ($o->orderDetails as $d)
                                    <div>
                                        {{ $d->schedule->movie->title ?? 'Film dihapus' }}
                                        /
                                        {{ $d->schedule->studio ?? '-' }}
                                        ×
                                        {{ $d->quantity }}
                                        =
                                        Rp {{ number_format($d->subtotal) }}
                                    </div>
                                @endforeach
                            </td>

                            <td>
                                Rp {{ number_format($o->total_price) }}
                            </td>

                            <td>
                                {{ strtoupper($o->status) }}
                            </td>

                            <td>
                                <form
                                    method="POST"
                                    action="{{ route('admin.orders.updateStatus', $o->id) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="status"
                                        class="border p-1"
                                        onchange="this.form.submit()"
                                    >
                                        <option
                                            value="pending"
                                            @selected($o->status === 'pending')
                                        >
                                            Pending
                                        </option>

                                        <option
                                            value="completed"
                                            @selected($o->status === 'completed')
                                        >
                                            Completed
                                        </option>

                                        <option
                                            value="cancelled"
                                            @selected($o->status === 'cancelled')
                                        >
                                            Cancelled
                                        </option>
                                    </select>
                                </form>
                            </td>

                            <td>
                                {{ $o->created_at->format('d-m-Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center">
                                Belum ada pesanan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <p class="mt-4 font-semibold">
                Jumlah transaksi: {{ $orders->count() }}
                |
                Total nilai pesanan: Rp {{ number_format($orders->sum('total_price')) }}
            </p>
        </div>
    </div>
</x-app-layout>
