{{-- resources/views/customer/checkout/payment_simulation.blade.php --}}
<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 md:p-8 text-center">
                    <div class="mb-6">
                        <img src="https://www.gstatic.com/images/icons/material/system/2x/payment_googblue_48dp.png" alt="E-Wallet Icon" class="mx-auto h-16 w-16 mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Simulasi Pembayaran E-Wallet</h3>
                        <p class="text-gray-600 mt-2">
                            Anda akan melakukan pembayaran untuk pesanan <strong class="text-indigo-600">{{ $order->order_code }}</strong>
                            dari tenant <strong class="text-indigo-600">{{ $order->tenant->name }}</strong>.
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-md mb-6">
                        <p class="text-sm text-gray-700">Total yang Harus Dibayar:</p>
                        <p class="text-3xl font-bold text-gray-900">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-500 mb-6">
                        Ini adalah halaman simulasi. Di aplikasi nyata, Anda akan diarahkan ke halaman penyedia E-Wallet.
                        Klik tombol di bawah untuk mensimulasikan pembayaran yang berhasil.
                    </p>

                    <form action="{{ route('checkout.payment.simulation.process', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full primary-button bg-green-600 hover:bg-green-700 text-lg px-8 py-4 text-white">
                            Bayar Sekarang (Simulasi Berhasil)
                        </button>
                    </form>

                    <div class="mt-6">
                        <a href="{{ route('customer.orders.show', $order) }}" class="text-sm text-gray-500 hover:underline">
                            Batalkan atau Bayar Nanti
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>