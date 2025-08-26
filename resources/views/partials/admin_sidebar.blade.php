<div class="sidebar">
  <h5>Admin</h5>
  <hr class="bg-secondary mx-3">

  <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    Dashboard
  </a>

  <a href="{{ route('mahasiswa.index') }}" class="{{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
    Data Mahasiswa
  </a>

  <a href="{{ route('dosen.index') }}" class="{{ request()->routeIs('dosen.*') ? 'active' : '' }}">
    Data Dosen
  </a>

  <a href="{{ route('admin.pengajuan.index') }}" class="{{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}">
    Pengajuan Skripsi
  </a>

  <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin logout?')" style="margin-top:20px;padding-left:20px;">
    @csrf
    <button type="submit" class="btn btn-link text-danger p-0" style="text-decoration:none;">
      Logout
    </button>
  </form>
</div>
