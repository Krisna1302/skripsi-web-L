<!-- ==============================
     Sidebar Dosen
     ============================== -->
<div class="sidebar">
    <!-- Judul Sidebar -->
    <h5>Dosen</h5>
    <hr class="bg-secondary mx-3">

    <!-- Dashboard -->
    <a href="{{ route('dashboard.dosen') }}" 
       class="{{ request()->routeIs('dashboard.dosen') ? 'active' : '' }}">
        Dashboard
    </a>

    <!-- Dropdown Pengajuan -->
    <a href="javascript:void(0)" onclick="toggleDropdown()" id="dropdownToggle">
        Pengajuan
        <span class="arrow" id="arrowIcon">▾</span>
    </a>

    <div id="dropdownMenu" 
         class="dropdown-sub slide-menu {{ request()->routeIs('pengajuan.*') ? 'open' : '' }}">
        <!-- Data Pengajuan -->
        <a href="{{ route('pengajuan.data') }}" 
           class="{{ request()->routeIs('pengajuan.data') ? 'active' : '' }}">
            Data Pengajuan
            @isset($jumlah_menunggu)
                @if ($jumlah_menunggu > 0)
                    <span class="badge bg-danger ms-2">{{ $jumlah_menunggu }}</span>
                @endif
            @endisset
        </a>

        <!-- History Pengajuan -->
        <a href="{{ route('pengajuan.history') }}" 
           class="{{ request()->routeIs('pengajuan.history') ? 'active' : '' }}">
            History
        </a>
    </div>

    <!-- Menu Profil Dosen -->
    <a href="{{ route('dosen.profile') }}" 
       class="{{ request()->routeIs('dosen.profile') ? 'active' : '' }}">
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
