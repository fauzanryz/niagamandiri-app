<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Nama file JSON tempat menyimpan data produk
    private $file = 'produk.txt';

    /**
     * Menampilkan halaman utama produk
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua data produk dari file
        $produk = $this->readJson();

        // Ambil data kategori dari file kategori
        $kategori = $this->readKategori();

        // Kirim data ke view produk.index
        return view('produk.index', compact('produk', 'kategori'));
    }

    /**
     * Menyimpan data produk baru ke file JSON
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required|string',
            'kategori' => 'required|string',
            'harga' => 'required|numeric'
        ]);

        // Ambil data produk lama
        $data = $this->readJson();

        // Tambahkan data produk baru
        $data[] = [
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'harga' => $request->harga
        ];

        // Tulis data ke file
        $this->writeJson($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Memperbarui data produk berdasarkan ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required|string',
            'kategori' => 'required|string',
            'harga' => 'required|numeric'
        ]);

        // Ambil data lama
        $data = $this->readJson();

        // Cek apakah ID produk ada
        if (!isset($data[$id])) {
            return redirect()->route('produk.index')->with('error', 'Data tidak ditemukan');
        }

        // Update data produk
        $data[$id] = [
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'harga' => $request->harga
        ];

        // Simpan perubahan
        $this->writeJson($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Menghapus data produk berdasarkan ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Ambil data lama
        $data = $this->readJson();

        // Cek apakah ID valid
        if (!isset($data[$id])) {
            return redirect()->route('produk.index')->with('error', 'Data tidak ditemukan');
        }

        // Hapus data berdasarkan ID
        unset($data[$id]);

        // Reset indeks array
        $data = array_values($data);

        // Simpan ke file
        $this->writeJson($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }

    /**
     * Membaca data produk dari file JSON
     *
     * @return array
     */
    private function readJson()
    {
        $path = storage_path('app/data/' . $this->file);

        // Jika file tidak ada, kembalikan array kosong
        if (!file_exists($path)) return [];

        // Baca isi file dan decode
        $content = file_get_contents($path);
        return json_decode($content, true) ?? [];
    }

    /**
     * Menulis data produk ke file JSON
     *
     * @param  array  $data
     * @return void
     */
    private function writeJson($data)
    {
        $path = storage_path('app/data/' . $this->file);

        // Encode dan simpan data ke file
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Membaca daftar kategori dari file kategori.txt
     *
     * @return array
     */
    private function readKategori()
    {
        $path = storage_path('app/data/kategori.txt');

        // Jika file tidak ada, kembalikan array kosong
        if (!file_exists($path)) return [];

        // Decode isi file menjadi array
        $content = file_get_contents($path);
        $kategori = json_decode($content, true);

        return is_array($kategori) ? $kategori : [];
    }
}
