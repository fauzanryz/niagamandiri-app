<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    // Nama file penyimpanan data penjualan
    private $file = 'penjualan.txt';

    // Nama file penyimpanan data produk
    private $produkFile = 'produk.txt';

    /**
     * Menampilkan halaman utama penjualan, termasuk fitur pencarian
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Ambil semua data penjualan dari file
        $data = $this->readJson();

        // Ambil daftar produk dari file
        $produkList = $this->getProdukList();

        // Filter data penjualan berdasarkan pencarian produk dan tanggal
        $filtered = collect($data)->filter(function ($row) use ($request) {
            $matchProduk = $request->search ? stripos($row['produk'], $request->search) !== false : true;
            $matchTanggal = $request->tanggal ? $row['tanggal'] === $request->tanggal : true;
            return $matchProduk && $matchTanggal;
        });

        // Kirim data ke view penjualan.index
        return view('penjualan.index', [
            'penjualan' => $filtered->values()->all(),
            'produkList' => array_keys($produkList),
            'search' => $request->search,
            'tanggal' => $request->tanggal
        ]);
    }

    /**
     * Menyimpan data penjualan baru
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'tanggal' => 'required|date',
            'produk' => 'required|string',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Ambil daftar harga produk
        $produkList = $this->getProdukList();

        // Cek apakah produk valid
        if (!isset($produkList[$request->produk])) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        // Hitung total harga berdasarkan jumlah dan harga produk
        $harga = $produkList[$request->produk];
        $total = $request->jumlah * $harga;

        // Tambahkan data baru ke dalam file
        $data = $this->readJson();
        $data[] = [
            'tanggal' => $request->tanggal,
            'produk' => $request->produk,
            'jumlah' => $request->jumlah,
            'total' => $total
        ];

        // Tulis ulang data ke file
        $this->writeJson($data);

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan');
    }

    /**
     * Memperbarui data penjualan berdasarkan ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'produk' => 'required|string',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Baca semua data dan produk
        $data = $this->readJson();
        $produkList = $this->getProdukList();

        // Validasi ID dan produk
        if (!isset($data[$id]) || !isset($produkList[$request->produk])) {
            return redirect()->route('penjualan.index')->with('error', 'Data tidak valid');
        }

        // Hitung total baru dan perbarui data
        $total = $request->jumlah * $produkList[$request->produk];
        $data[$id] = [
            'tanggal' => $request->tanggal,
            'produk' => $request->produk,
            'jumlah' => $request->jumlah,
            'total' => $total
        ];

        // Simpan kembali ke file
        $this->writeJson($data);

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui');
    }

    /**
     * Menghapus data penjualan berdasarkan ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Ambil data dari file
        $data = $this->readJson();

        // Validasi ID
        if (!isset($data[$id])) {
            return redirect()->route('penjualan.index')->with('error', 'Data tidak ditemukan');
        }

        // Hapus data berdasarkan ID dan reset index array
        unset($data[$id]);
        $this->writeJson(array_values($data));

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus');
    }

    /**
     * Membaca file penjualan.txt dan mengembalikannya sebagai array
     *
     * @return array
     */
    private function readJson()
    {
        $path = storage_path('app/data/' . $this->file);

        // Jika file tidak ditemukan, kembalikan array kosong
        if (!file_exists($path)) return [];

        // Baca file dan decode JSON
        $content = file_get_contents($path);
        return json_decode($content, true) ?? [];
    }

    /**
     * Menulis array ke file penjualan.txt dalam format JSON
     *
     * @param  array  $data
     * @return void
     */
    private function writeJson($data)
    {
        $path = storage_path('app/data/' . $this->file);
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Membaca file produk.txt dan mengembalikannya sebagai array [nama => harga]
     *
     * @return array
     */
    private function getProdukList()
    {
        $path = storage_path('app/data/' . $this->produkFile);

        // Jika file tidak ditemukan, kembalikan array kosong
        if (!file_exists($path)) return [];

        // Decode JSON dan ubah ke format nama => harga
        $json = file_get_contents($path);
        $produk = json_decode($json, true);
        $result = [];

        foreach ($produk as $p) {
            $result[$p['nama']] = $p['harga'];
        }

        return $result;
    }
}
