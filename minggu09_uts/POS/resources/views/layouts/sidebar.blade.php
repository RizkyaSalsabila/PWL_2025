{{-- ------------------------------------- *jobsheet 05* ------------------------------------- --}}
{{-- JS5 - P1(12) --}}
<!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 mb-3 d-flex">
      <div class="image">
        <a href="{{ url('/profile') }}" class="image mb-2 position-relative">
          <img src="{{ asset('storage/profiles/' . (Auth::user()->profile_photo ?? 'profile.jpg')) }}" class="img-circle elevation-2" alt="User Image" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid white;">
        </a>
      </div>
      <div class="info">
        {{-- <a href="#" class="d-block">Alexander Pierce</a> --}}
        <h5><span style="color:rgb(0, 183, 255)"><b>{{ Auth::user()->nama }}</b></span></h5>
        <p style="color:rgb(0, 183, 255)">Online</p>
      </div>
    </div>

    {{-- JS5 - P2(4) --}}
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div> 

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : ''}} ">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>
        <li class="nav-header">Data Pengguna</li>
        <li class="nav-item">
            <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level') ? 'active' : '' }}">
                <i class="nav-icon fas fa-layer-group"></i>
                <p>Level User</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
                <i class="nav-icon far fa-user"></i>
                <p>Data User</p>
            </a>
        </li>

        <li class="nav-header">Data Barang</li>
        <li class="nav-item">
            <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori') ? 'active' : '' }}">
                <i class="nav-icon far fa-bookmark"></i>
                <p>Kategori Barang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang') ? 'active' : '' }}">
                <i class="nav-icon far fa-list-alt"></i>
                <p>Data Barang</p>
            </a>
        </li>

        <li class="nav-header">Data Transaksi</li>
        <li class="nav-item">
            <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cubes"></i>
                <p>Stok Barang</p>
            </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/penjualan') }}" class="nav-link {{ ($activeMenu == 'penjualan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>Transaksi Penjualan</p>
          </a>
      </li>
      <li class="nav-header">Data Supplier</li>
        <li class="nav-item">
            <a href="{{ url('/supplier') }}" class="nav-link {{ ($activeMenu == 'supplier') ? 'active' : '' }}">
                <i class="nav-icon fas fa-warehouse"></i>
                <p>Supplier Barang</p>
            </a>
        </li>

        {{-- JS7 - P2(authorization) --}}
        <li class="nav-item mt-5">
          <a href="#" class="nav-link" onclick="confirmLogout(event)">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
      </li>
    </ul>
  </nav>
  </div>

@push('js')
<script>
    function confirmLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah yakin ingin keluar dari sistem?',
            text: "Sesi Anda akan diakhiri.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
@endpush