@extends('layouts.app')

@section('content')

{{-- Container utama dashboard --}}
<div class="container px-1 pt-2 mb-3 mt-3 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
    {{-- Judul halaman --}}
    <h1 class="mb-1 mt-2">Dashboard</h1>

    {{-- Breadcrumb navigasi --}}
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="">
                    {{-- Icon home --}}
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 
                              0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
</div>

{{-- Grafik Penjualan 6 Bulan Terakhir --}}
<div class="card mb-4">
    <div class="card-header bg-primary text-white">Statistik Penjualan 6 Bulan Terakhir</div>
    <div class="card-body">
        <canvas id="salesChart" height="100"></canvas>
    </div>
</div>

{{-- Daftar Produk Terjual Terbanyak --}}
<div class="card mb-4">
    <div class="card-header bg-primary text-white">Produk Terjual Terbanyak</div>
    <div class="card-body">
        <ol>
            @foreach($produkTerjual as $produk => $jumlah)
                <li>{{ $produk }} - {{ $jumlah }} pcs</li>
            @endforeach
        </ol>
    </div>
</div>

{{-- Daftar Produk Terlaris berdasarkan Kategori --}}
<div class="card mb-4">
    <div class="card-header bg-primary text-white">Produk Terlaris Berdasarkan Kategori</div>
    <div class="card-body">
        <ol>
            @foreach($produkKategori as $produk => $info)
                <li>
                    {{ $produk }} - Rp {{ number_format($info['total']) }}
                    <span class="badge bg-primary text-dark">({{ $info['kategori'] }})</span>
                </li>
            @endforeach
        </ol>
    </div>
</div>

{{-- Total Penghasilan dan Kategori Penjualan --}}
<div class="card mb-4">
    <div class="card-header bg-primary text-white">Total Penghasilan & Kategori</div>
    <div class="card-body">
        <p><strong>Total Penghasilan:</strong> Rp {{ number_format($totalPenghasilan) }}</p>
        <p><strong>Kategori Penjualan:</strong> 
            <span class="badge bg-primary">{{ $kategoriPenjualan }}</span>
        </p>
    </div>
</div>
@endsection

@section('js')
{{-- Tambahkan Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Script untuk render Chart Penjualan --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart');

    // Pastikan elemen canvas tersedia sebelum membuat chart
    if (ctx) {
        const chart = new Chart(ctx, {
            type: 'bar', // Jenis chart: bar
            data: {
                // Label bulan dari controller
                labels: {!! json_encode($labelBulan) !!},
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: {!! json_encode($nilaiBulan) !!}, // Data total penjualan
                    backgroundColor: '#272C41', // Warna latar belakang batang
                    borderColor: '#272C41',     // Warna border batang
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true // Mulai dari nol untuk skala Y
                    }
                }
            }
        });
    }
});
</script>
@endsection
