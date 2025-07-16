<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    // Nama file penyimpanan data penjualan dalam format JSON
    private $file = 'penjualan.txt';

    /**
     * Menampilkan halaman utama dashboard
     * Memuat data penjualan, statistik, dan grafik
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Membaca dan memproses data penjualan dari file
        $penjualan = $this->readData();

        // Menghitung penghasilan per bulan
        $penghasilanPerBulan = $this->getPenghasilanPerBulan($penjualan);

        // Menghitung jumlah produk yang terjual (descending)
        $produkTerjual = $this->getProdukTerjual($penjualan);

        // Mendapatkan produk terlaris berdasarkan total & kategori
        $produkKategori = $this->getProdukTerlarisByKategori($penjualan);

        // Menghitung total keseluruhan penghasilan
        $totalPenghasilan = $penjualan->sum('total');

        // Menentukan kategori total penghasilan
        $kategoriPenjualan = $this->klasifikasiKategori($totalPenghasilan);

        // Menyiapkan label dan nilai untuk grafik chart
        $labelBulan = $penghasilanPerBulan->keys();
        $nilaiBulan = $penghasilanPerBulan->values();

        // Mengembalikan tampilan view dashboard dengan data
        return view('dashboard.index', [
            'penghasilanPerBulan' => $penghasilanPerBulan,
            'produkTerjual' => $produkTerjual,
            'produkKategori' => $produkKategori,
            'totalPenghasilan' => $totalPenghasilan,
            'kategoriPenjualan' => $kategoriPenjualan,
            'labelBulan' => $labelBulan,
            'nilaiBulan' => $nilaiBulan
        ]);
    }

    /**
     * Membaca file penjualan.txt dan mengubahnya ke Collection
     *
     * @return \Illuminate\Support\Collection
     */
    private function readData(): Collection
    {
        $path = storage_path('app/data/' . $this->file);

        // Jika file tidak ditemukan, kembalikan collection kosong
        if (!file_exists($path)) return collect();

        // Ambil isi file dalam format JSON dan decode ke array
        $json = file_get_contents($path);
        $data = json_decode($json, true);

        // Ubah array menjadi Collection dan transformasi data
        return collect($data)->map(function ($item) {
            return [
                'tanggal' => $item['tanggal'],
                'produk' => $item['produk'],
                'jumlah' => (int) $item['jumlah'],
                'total' => (int) $item['total'],
                'bulan' => date('M', strtotime($item['tanggal'])),
                'tahun' => date('Y', strtotime($item['tanggal'])),
                'kategori' => $this->klasifikasiKategori($item['total'])
            ];
        });
    }

    /**
     * Menghitung total penghasilan per bulan
     *
     * @param Collection $data
     * @return Collection
     */
    private function getPenghasilanPerBulan(Collection $data)
    {
        // Kelompokkan berdasarkan bulan, lalu jumlahkan total
        return $data->groupBy('bulan')
            ->map(fn($items) => $items->sum('total'))
            ->sortKeys(); // urut berdasarkan urutan bulan
    }

    /**
     * Menghitung jumlah total produk terjual (descending)
     *
     * @param Collection $data
     * @return Collection
     */
    private function getProdukTerjual(Collection $data)
    {
        // Kelompokkan berdasarkan produk, jumlahkan, urut dari terbanyak
        return $data->groupBy('produk')
            ->map(fn($items) => $items->sum('jumlah'))
            ->sortDesc(); // descending order
    }

    /**
     * Mendapatkan daftar produk terlaris berdasarkan total dan kategori
     *
     * @param Collection $data
     * @return Collection
     */
    private function getProdukTerlarisByKategori(Collection $data)
    {
        // Kelompokkan berdasarkan produk dan hitung total per produk
        return $data->groupBy('produk')
            ->map(function ($items) {
                return [
                    'total' => $items->sum('total'),
                    'kategori' => $items->first()['kategori'] // ambil kategori pertama
                ];
            })->sortByDesc('total'); // urut berdasarkan total terbesar
    }

    /**
     * Menentukan klasifikasi kategori penghasilan
     * 
     * @param int $jumlah
     * @return string
     */
    private function klasifikasiKategori($jumlah)
    {
        if ($jumlah >= 100_000_000) return 'Sangat Tinggi';
        if ($jumlah >= 50_000_000) return 'Sedang';
        if ($jumlah >= 20_000_000) return 'Cukup';
        if ($jumlah >= 10_000_000) return 'Rendah';
        return 'Sangat Rendah';
    }
}
