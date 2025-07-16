@extends('layouts.app')

@section('content')

{{-- Container Header: Judul halaman dan breadcrumb --}}
<div class="container px-1 pt-2 mb-3 mt-3 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
 <h1 class="mb-1 mt-2">Kategori Produk</h1>
 <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
  <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
   <li class="breadcrumb-item">
    <a href="">
     {{-- Icon Home --}}
     <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
       d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 
                              01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 
                              001 1m-6 0h6"></path>
     </svg>
    </a>
   </li>
   <li class="breadcrumb-item active" aria-current="page">Kategori Produk</li>
  </ol>
 </nav>
</div>

{{-- Menampilkan alert pesan sukses --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Menampilkan alert pesan error --}}
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Form Tambah Kategori --}}
<div class="card mb-4">
 <div class="card-body">
  <form method="POST" action="{{ route('kategori.store') }}">
   @csrf
   <div class="row">
    {{-- Input nama kategori --}}
    <div class="col-md-11 mb-3">
     <label>Nama Kategori</label>
     <input type="text" name="nama" class="form-control" required>
    </div>

    {{-- Tombol simpan --}}
    <div class="col-md-1 mb-3 d-flex align-items-end justify-content-end">
     <button type="submit" class="btn btn-primary">Tambah</button>
    </div>
   </div>
  </form>

  {{-- Tabel Daftar Kategori --}}
  <table class="table table-bordered table-striped">
   <thead>
    <tr>
     <th>Nama Kategori</th>
     <th width="180">Aksi</th>
    </tr>
   </thead>
   <tbody>
    {{-- Looping semua kategori --}}
    @foreach($data as $index => $row)
    <tr>
     <td>{{ $row }}</td>
     <td>
      {{-- Tombol buka modal edit --}}
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $index }}">Edit</button>

      {{-- Tombol buka modal hapus --}}
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $index }}">Hapus</button>

      {{-- Modal Edit Kategori --}}
      <div class="modal fade" id="editModal{{ $index }}" tabindex="-1">
       <div class="modal-dialog">
        <form method="POST" action="{{ route('kategori.update', $index) }}">
         @csrf @method('PUT')
         <div class="modal-content">
          <div class="modal-header">
           <h5 class="modal-title">Edit Kategori</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
           <input type="text" name="nama" class="form-control" value="{{ $row }}" required>
          </div>
          <div class="modal-footer">
           <button type="submit" class="btn btn-primary">Simpan</button>
           <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
          </div>
         </div>
        </form>
       </div>
      </div>

      {{-- Modal Hapus Kategori --}}
      <div class="modal fade" id="deleteModal{{ $index }}" tabindex="-1">
       <div class="modal-dialog">
        <form method="POST" action="{{ route('kategori.destroy', $index) }}">
         @csrf @method('DELETE')
         <div class="modal-content">
          <div class="modal-header">
           <h5 class="modal-title">Hapus Kategori</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
           Yakin ingin menghapus kategori <strong>{{ $row }}</strong>?
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