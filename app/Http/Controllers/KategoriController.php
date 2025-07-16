<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Nama file tempat menyimpan data kategori
    private $file = 'kategori.txt';

    /**
     * Menampilkan daftar semua kategori
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Membaca data dari file
        $data = $this->readData();

        // Mengirim data ke view
        return view('kategori.index', ['data' => $data]);
    }

    /**
     * Menyimpan data kategori baru
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input nama kategori
        $request->validate(['nama' => 'required|string']);

        // Membaca data lama dari file
        $data = $this->readData();

        // Menambahkan nama kategori baru ke dalam array
        $data[] = $request->nama;

        // Menulis data baru ke file
        $this->writeData($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Memperbarui data kategori berdasarkan ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input nama kategori
        $request->validate(['nama' => 'required|string']);

        // Membaca semua data dari file
        $data = $this->readData();

        // Jika data kategori tidak ditemukan berdasarkan ID, kembali dengan pesan error
        if (!isset($data[$id])) {
            return redirect()->route('kategori.index')->with('error', 'Data tidak ditemukan');
        }

        // Update data kategori yang sesuai ID
        $data[$id] = $request->nama;

        // Simpan perubahan ke file
        $this->writeData($data);

        // Redirect dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Menghapus data kategori berdasarkan ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Membaca semua data dari file
        $data = $this->readData();

        // Jika data tidak ditemukan, kembalikan pesan error
        if (!isset($data[$id])) {
            return redirect()->route('kategori.index')->with('error', 'Data tidak ditemukan');
        }

        // Hapus data berdasarkan ID
        unset($data[$id]);

        // Reset index array agar berurutan kembali
        $data = array_values($data);

        // Simpan data yang sudah dihapus ke file
        $this->writeData($data);

        // Redirect dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }

    /**
     * Membaca file kategori.txt dan mengubahnya ke array
     *
     * @return array
     */
    private function readData()
    {
        // Menentukan path file penyimpanan
        $path = storage_path('app/data/' . $this->file);

        // Jika file belum ada, kembalikan array kosong
        if (!file_exists($path)) return [];

        // Membaca isi file dan meng-decode JSON menjadi array
        $json = file_get_contents($path);
        return json_decode($json, true) ?: [];
    }

    /**
     * Menulis data array ke dalam file kategori.txt dalam format JSON
     *
     * @param  array  $data
     * @return void
     */
    private function writeData($data)
    {
        // Tentukan path file
        $path = storage_path('app/data/' . $this->file);

        // Encode array ke JSON dengan format rapi dan simpan ke file
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }
}
