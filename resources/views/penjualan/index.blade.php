@extends('layouts.app')

@section('content')
{{-- Header halaman dan breadcrumb --}}
<div class="container px-1 pt-2 mb-3 mt-3 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
 <h1 class="mb-1 mt-2">Data Penjualan</h1>
 <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
  <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
   <li class="breadcrumb-item">
    <a href="">
     {{-- Icon Home --}}
     <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
     </svg>
    </a>
   </li>
   <li class="breadcrumb-item active" aria-current="page">Data Penjualan</li>
  </ol>
 </nav>
</div>

{{-- Menampilkan notifikasi sukses atau error --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Card utama --}}
<div class="card mb-4">
 <div class="card-body">

  {{-- Form pencarian data penjualan --}}
  <form method="GET" action="{{ route('penjualan.index') }}" class="row g-3 mb-3">
   <label class="mb-0">Cari Penjualan</label>
   <div class="col-md-6 mt-2">
    <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ $search }}">
   </div>
   <div class="col-md-5 mt-2">
    <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
   </div>
   <div class="col-md-1 mt-2">
    <button type="submit" class="btn btn-primary">Cari</button>
   </div>
  </form>

  {{-- Form tambah penjualan baru --}}
  <form method="POST" action="{{ route('penjualan.store') }}" class="mb-4">
   @csrf
   <div class="row">
    <div class="col-md-4 mb-2">
     <label>Tanggal Transaksi</label>
     <input type="date" name="tanggal" class="form-control" required>
    </div>
    <div class="col-md-4 mb-2">
     <label>Nama Produk</label>
     <select name="produk" class="form-control" required>
      <option value="">Pilih Produk</option>
      @foreach($produkList as $p)
      <option value="{{ $p }}">{{ $p }}</option>
      @endforeach
     </select>
    </div>
    <div class="col-md-4 mb-2">
     <label>Jumlah Terjual</label>
     <input type="number" name="jumlah" class="form-control" required>
    </div>
   </div>
   <div class="text-end">
    <button type="submit" class="btn btn-primary mt-2">Tambah</button>
   </div>
  </form>

  {{-- Tabel daftar penjualan --}}
  <table class="table table-bordered table-striped">
   <thead>
    <tr>
     <th>Tanggal</th>
     <th>Produk</th>
     <th>Jumlah</th>
     <th>Total</th>
     <th>Aksi</th>
    </tr>
   </thead>
   <tbody>
    @foreach($penjualan as $index => $row)
    <tr>
     <td>{{ $row['tanggal'] }}</td>
     <td>{{ $row['produk'] }}</td>
     <td>{{ $row['jumlah'] }}</td>
     <td>Rp {{ number_format($row['total']) }}</td>
     <td>
      {{-- Tombol Edit --}}
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $index }}">Edit</button>

      {{-- Tombol Hapus --}}
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $index }}">Hapus</button>

      {{-- Modal Edit Penjualan --}}
      <div class="modal fade" id="editModal{{ $index }}">
       <div class="modal-dialog">
        <form method="POST" action="{{ route('penjualan.update', $index) }}">
         @csrf @method('PUT')
         <div class="modal-content">
          <div class="modal-header">
           <h5>Edit Penjualan</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
           <div class="mb-2">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $row['tanggal'] }}" required>
           </div>
           <div class="mb-2">
            <label>Produk</label>
            <select name="produk" class="form-control" required>
             @foreach($produkList as $p)
             <option value="{{ $p }}" {{ $row['produk'] == $p ? 'selected' : '' }}>{{ $p }}</option>
             @endforeach
            </select>
           </div>
           <div class="mb-2">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $row['jumlah'] }}" required>
           </div>
          </div>
          <div class="modal-footer">
           <button type="submit" class="btn btn-primary">Simpan</button>
           <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
          </div>
         </div>
        </form>
       </div>
      </div>

      {{-- Modal Hapus Penjualan --}}
      <div class="modal fade" id="deleteModal{{ $index }}">
       <div class="modal-dialog">
        <form method="POST" action="{{ route('penjualan.destroy', $index) }}">
         @csrf @method('DELETE')
         <div class="modal-content">
          <div class="modal-header">
           <h5>Hapus Penjualan</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
           Yakin ingin menghapus penjualan <strong>{{ $row['produk'] }}</strong>?
          </div>
          <div class="modal-footer">
           <button type="submit" class="btn btn-primary">Hapus</button>
           <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
          </div>
         </div>
        </form>
       </div>
      </div>
     </td>
    </tr>
    @endforeach
   </tbody>
  </table>

 </div>
</div>
@endsection
