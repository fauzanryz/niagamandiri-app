@extends('layouts.app')

@section('content')
{{-- Header halaman dan breadcrumb navigasi --}}
<div class="container px-1 pt-2 mb-3 mt-3 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
 <h1 class="mb-1 mt-2">Data Produk</h1>
 <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
  <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
   <li class="breadcrumb-item">
    <a href="">
     {{-- Icon Home --}}
     <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
       d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
     </svg>
    </a>
   </li>
   <li class="breadcrumb-item active" aria-current="page">Data Produk</li>
  </ol>
 </nav>
</div>

{{-- Tampilkan pesan sukses jika ada --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Form tambah produk --}}
<div class="card mb-4">
 <div class="card-body">
  <form method="POST" action="{{ route('produk.store') }}">
   @csrf
   <div class="row">
    {{-- Input nama produk --}}
    <div class="col-md-4 mb-3">
     <label>Nama Produk</label>
     <input type="text" name="nama" class="form-control" required>
    </div>
    {{-- Pilihan kategori produk --}}
    <div class="col-md-4 mb-3">
     <label>Kategori</label>
     <select name="kategori" class="form-control" required>
      @foreach($kategori as $kat)
      <option value="{{ $kat }}">{{ $kat }}</option>
      @endforeach
     </select>
    </div>
    {{-- Input harga produk --}}
    <div class="col-md-4 mb-3">
     <label>Harga</label>
     <input type="number" name="harga" class="form-control" required>
    </div>
   </div>

   <div class="text-end mb-3">
    <button type="submit" class="btn btn-primary">Simpan</button>
   </div>
  </form>

  {{-- Tabel data produk --}}
  <table class="table table-bordered table-striped">
   <thead>
    <tr>
     <th>Nama</th>
     <th>Kategori</th>
     <th>Harga</th>
     <th>Aksi</th>
    </tr>
   </thead>
   <tbody>
    @foreach($produk as $index => $item)
    <tr>
     <td>{{ $item['nama'] }}</td>
     <td>{{ $item['kategori'] }}</td>
     <td>Rp {{ number_format($item['harga']) }}</td>
     <td>
      {{-- Tombol untuk membuka modal edit --}}
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $index }}">Edit</button>
      {{-- Tombol untuk membuka modal hapus --}}
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $index }}">Hapus</button>

      <!-- Modal Edit Produk -->
      <div class="modal fade" id="editModal{{ $index }}" tabindex="-1">
       <div class="modal-dialog">
        <form method="POST" action="{{ route('produk.update', $index) }}">
         @csrf @method('PUT')
         <div class="modal-content">
          <div class="modal-header">
           <h5 class="modal-title">Edit Produk</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
           {{-- Input nama produk (edit) --}}
           <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="{{ $item['nama'] }}" required>
           </div>
           {{-- Pilihan kategori produk (edit) --}}
           <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
             @foreach($kategori as $kat)
             <option value="{{ $kat }}" {{ $item['kategori'] == $kat ? 'selected' : '' }}>{{ $kat }}</option>
             @endforeach
            </select>
           </div>
           {{-- Input harga produk (edit) --}}
           <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $item['harga'] }}" required>
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

      <!-- Modal Hapus Produk -->
      <div class="modal fade" id="deleteModal{{ $index }}" tabindex="-1">
       <div class="modal-dialog">
        <form method="POST" action="{{ route('produk.destroy', $index) }}">
         @csrf @method('DELETE')
         <div class="modal-content">
          <div class="modal-header">
           <h5 class="modal-title">Hapus Produk</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
           Yakin ingin menghapus <strong>{{ $item['nama'] }}</strong>?
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