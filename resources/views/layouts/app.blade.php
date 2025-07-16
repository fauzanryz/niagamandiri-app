<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  {{-- Meta dan Title --}}
  <title>PT. NIAGA MANDIRI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="title" content="PT. NIAGA MANDIRI">

  {{-- Include CSS untuk notifikasi dan styling --}}
  <link type="text/css" href="{{ asset('volt/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
  <link type="text/css" href="{{ asset('volt/vendor/notyf/notyf.min.css') }}" rel="stylesheet">
  <link type="text/css" href="{{ asset('volt/css/volt.css') }}" rel="stylesheet">

  {{-- Include Chart dan Wordcloud JS --}}
  <script src="{{ asset('js/chart.min.js') }}"></script>
  <script src="{{ asset('js/wordcloud2.min.js') }}"></script>
</head>

<body>
  {{-- Navbar untuk layar kecil (responsive) --}}
  <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <div class="d-flex align-items-center">
      <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  {{-- Sidebar utama --}}
  <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">

      {{-- Sidebar Header untuk versi mobile --}}
      <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center p-3">
        <div class="collapse-close d-md-none">
          <a href="#sidebarMenu" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true"
            aria-label="Toggle navigation">
            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 
              111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 
              4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </a>
        </div>
      </div>

      {{-- Sidebar menu navigasi --}}
      <ul class="nav flex-column pt-3 pt-md-0">
        {{-- Nama Perusahaan --}}
        <li class="nav-item">
          <div class="nav-link d-flex align-items-center">
            <span class="mt-1 sidebar-text" style="margin-left: 12px; font-weight: bold;">PT. NIAGA MANDIRI</span>
          </div>
        </li>

        <li role="separator" class="dropdown-divider mt-2 mb-2 border-gray-700"></li>

        {{-- Link ke Dashboard --}}
        <li class="nav-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
          <a href="{{ route('dashboard') }}" class="nav-link">
            <span class="sidebar-icon"><i class="fas fa-home me-2"></i></span>
            <span class="sidebar-text">Dashboard</span>
          </a>
        </li>

        {{-- Link ke Data Penjualan --}}
        <li class="nav-item {{ Request::is('penjualan*') ? 'active' : '' }}">
          <a href="{{ route('penjualan.index') }}" class="nav-link">
            <span class="sidebar-icon"><i class="fas fa-file-invoice-dollar me-2"></i></span>
            <span class="sidebar-text">Data Penjualan</span>
          </a>
        </li>

        {{-- Link ke Data Produk --}}
        <li class="nav-item {{ Request::is('produk*') ? 'active' : '' }}">
          <a href="{{ route('produk.index') }}" class="nav-link">
            <span class="sidebar-icon"><i class="fas fa-box-open me-2"></i></span>
            <span class="sidebar-text">Data Produk</span>
          </a>
        </li>

        {{-- Link ke Kategori Produk --}}
        <li class="nav-item {{ Request::is('kategori*') ? 'active' : '' }}">
          <a href="{{ route('kategori.index') }}" class="nav-link">
            <span class="sidebar-icon"><i class="fas fa-tags me-2"></i></span>
            <span class="sidebar-text">Kategori Produk</span>
          </a>
        </li>

      </ul>
    </div>
  </nav>

  {{-- Konten utama halaman --}}
  <main class="content">
    {{-- Slot konten dinamis --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="bg-white rounded shadow p-4 mb-4 mt-4">
      <div class="row">
        <div class="col-12 col-md-6 mb-4 mb-md-0">
          <p class="mb-0 text-center text-md-start">© 2025 All rights reserved.</p>
        </div>
        <div class="col-12 col-md-6 text-end">
          <p class="mb-0 text-center text-md-end">made with &lt;3</p>
        </div>
      </div>
    </footer>
  </main>

  {{-- Script bawaan vendor --}}
  <script src="{{ asset('volt/vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
  <script src="{{ asset('volt/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('volt/vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>
  <script src="{{ asset('volt/vendor/nouislider/distribute/nouislider.min.js') }}"></script>
  <script src="{{ asset('volt/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>
  <script src="{{ asset('vendor/chartist/dist/chartist.min.js') }}"></script>
  <script src="{{ asset('vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
  <script src="{{ asset('volt/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>
  <script src="{{ asset('volt/vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
  <script src="{{ asset('volt/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>
  <script src="{{ asset('volt/vendor/notyf/notyf.min.js') }}"></script>
  <script src="{{ asset('volt/vendor/simplebar/dist/simplebar.min.js') }}"></script>
  <script async defer="defer" src="https://buttons.github.io/buttons.js"></script>
  <script src="{{ asset('volt/assets/js/volt.js') }}"></script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/..." crossorigin="anonymous"></script>

  {{-- Slot untuk JS tambahan setiap halaman --}}
  @yield('js')

</body>

</html>