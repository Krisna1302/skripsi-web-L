<!-- ==============================
     Sidebar Mahasiswa
     ============================== -->
<div class="sidebar">
  <!-- Judul Sidebar -->
  <h5>Mahasiswa</h5>
  <hr class="bg-secondary mx-3">

  <!-- Dashboard -->
  <a href="{{ route('dashboard') }}" 
     class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
    Dashboard
  </a>

  <!-- Dropdown Pengajuan -->
  <a href="javascript:void(0)" onclick="toggleDropdown()" id="dropdownToggle">
    Pengajuan
    <span class="arrow" id="arrowIcon">▾</span>
  </a>

  <div id="dropdownMenu" 
       class="dropdown-sub slide-menu {{ request()->routeIs('pengajuan.*') ? 'open' : '' }}">
    <!-- Ajukan Judul Skripsi -->
    <a href="{{ route('pengajuan.ajukan') }}" 
       class="{{ request()->routeIs('pengajuan.ajukan') ? 'active' : '' }}">
      Ajukan
    </a>

    <!-- Status Pengajuan -->
    <a href="{{ route('pengajuan.status') }}" 
       class="{{ request()->routeIs('pengajuan.status') ? 'active' : '' }}">
      Status
    </a>
  </div>

  <!-- Menu Profil Mahasiswa -->
  <a href="{{ route('mahasiswa.profile') }}" 
     class="{{ request()->routeIs('mahasiswa.profile') ? 'active' : '' }}">
    Pengaturan Profil
  </a>

  <!-- Logout Button -->
  <form action="{{ route('logout') }}" method="POST" 
        onsubmit="return confirm('Yakin ingin logout?')" 
        style="margin-top: 20px; padding-left: 20px;">
    @csrf
    <button type="submit" class="btn btn-link text-danger p-0" style="text-decoration:none;">
      Logout
    </button>
  </form>
</div>

<!-- ==============================
     Script Toggle Dropdown
     ============================== -->
<script>
function toggleDropdown() {
  const menu = document.getElementById('dropdownMenu');
  const arrow = document.getElementById('arrowIcon');

  // Toggle class untuk buka/tutup dropdown
  menu.classList.toggle('open');

  // Ubah simbol panah ▾ ke ▴ saat dropdown terbuka
  arrow.textContent = menu.classList.contains('open') ? '▴' : '▾';
}
</script>
