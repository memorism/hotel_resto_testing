{{-- ini yang ada tombol --}}
<x-app-layout>
    {{-- header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Data Transaksi Keseluruhan') }}
            </h2>
            <a href="{{ route('hotel.booking.create') }}" class="btn btn-primary">
                Tambah Data
            </a>
        </div>
    </x-slot>
{{-- ini yang ga ada tombol --}}
<x-slot name="header">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Dashboard Keuangan Hotel') }}
        </h2>
        <a class="invisible btn btn-primary">test</a>
    </div>
</x-slot>


<div class="overflow-x-auto">
    <table class="min-w-full border divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-50">
