@extends('layouts.app')

@section('title', 'Data Dosen')

@push('styles')
<style>
/* ==============================
   Body & Heading
   ============================== */
body { 
    background-color: #1e1e2f; 
    color: #f1f1f1; 
    font-family: 'Segoe UI', sans-serif; 
}
h2 { 
    margin-bottom: 20px; 
    font-weight: 600; 
}

/* ==============================
   Filter Card
   ============================== */
.filter-card {
    width: 100%;
    background-color: #252536;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    color: #fff;
    backdrop-filter: blur(8px);
}
.filter-card .form-control,
.filter-card select {
    background-color: #1f1f2f;
    color: #fff;
    border: 1px solid #555;
}
.filter-card .btn-primary { background: #4e9af1; border: none; }
.filter-card .btn-primary:hover { background: #6aa8f9; }
.filter-card .btn-secondary { background: #6c757d; border: none; }

/* ==============================
   Table Glassy Style
   ============================== */
.table-responsive { overflow-x: visible; }
.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px;
}
.table thead tr th {
    background-color: rgba(31,31,46,0.9);
    color: #f1f1f1;
    font-weight: 600;
    padding: 12px;
    text-align: center;
}
.table tbody tr {
    background: rgba(42,43,61,0.6);
    backdrop-filter: blur(12px);
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.table tbody tr:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,123,255,0.4);
}
.table tbody td {
    background: transparent;
    padding: 14px 12px;
    vertical-align: middle;
    color: #f1f1f1;
    text-align: center;
}

/* ==============================
   Buttons
   ============================== */
.btn-glassy {
    background: rgba(0,123,255,0.8); 
    backdrop-filter: blur(8px);
    border: none; 
    color: #fff;
    padding: 8px 18px;
    border-radius: 12px;
    transition: 0.3s ease;
}
.btn-glassy:hover {
    background: rgba(0,123,255,1);
    color: #fff;
}

/* ==============================
   Empty State
   ============================== */
.empty-message { 
    text-align: center; 
    padding: 40px; 
    font-size: 1.1rem; 
    color: #ffc107; 
    background: rgba(42,43,61,0.6); 
    backdrop-filter: blur(12px);
    border-radius: 12px; 
}

/* ==============================
   Status / Password Badges
   ============================== */
.status-badge, .password-badge { 
    font-weight: 600; 
    padding: 6px 14px; 
    border-radius: 20px; 
    display: inline-block; 
    font-size: 0.85rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}
.password-badge { color: #fff; }
.password-weak { background: rgba(220,53,69,0.85); box-shadow: 0 0 8px rgba(220,53,69,0.6);}
.password-medium { background: rgba(255,193,7,0.85); box-shadow: 0 0 8px rgba(255,193,7,0.6);}
.password-strong { background: rgba(40,167,69,0.85); box-shadow: 0 0 8px rgba(40,167,69,0.6);}

/* ==============================
   Foto
   ============================== */
.foto-wrapper {
    width: 50px;
    height: 50px;
    overflow: hidden;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border: 2px solid rgba(255,255,255,0.2);
}
.foto-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* ==============================
   Responsive / Mobile Friendly
   ============================== */
@media (max-width: 767px) {
    .table thead {
        display: none;
    }
    .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
        text-align: left;
    }
    .table tr {
        margin-bottom: 15px;
        border-radius: 12px;
        overflow: hidden;
        background: rgba(42,43,61,0.6);
        border: 1px solid #3e3e50;
        padding: 8px 10px;
    }
    .table tbody td {
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;
        padding: 10px 5px;
        gap: 12px;
    }
    .table td::before {
        content: attr(data-label);
        flex: 0 0 110px;
        font-weight: 600;
        color: #00bcd4;
        text-align: left;
    }
    .table td {
        text-align: left !important;
        white-space: normal;
        word-wrap: break-word;
    }
    .foto-wrapper {
        margin: 0;
    }
}
</style>
@endpush

@section('content')
<h2 data-aos="fade-down">Daftar Dosen</h2>

<!-- Tombol Tambah -->
<div data-aos="fade-down" data-aos-delay="100" class="mb-3">
    <a href="{{ route('dosen.create') }}" class="btn btn-glassy">Tambah Dosen</a>
</div>

<!-- Filter Form -->
<div class="filter-card" data-aos="fade-up" data-aos-delay="50">
    <form method="GET" action="{{ route('dosen.index') }}">
        <div class="row g-2">
            <div class="col-md-6">
                <label>Nama Dosen</label>
                <select name="nama" class="form-control">
                    <option value="">Semua</option>
                    @foreach($nama_dosen as $nama)
                        <option value="{{ $nama }}" {{ request('nama') == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Prodi</label>
                <select name="kaprodi" class="form-control">
                    <option value="">Semua</option>
                    @foreach($prodi_dosen as $prodi)
                        <option value="{{ $prodi }}" {{ request('kaprodi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
@endif

@if($dosen->count() > 0)
<div class="table-responsive" data-aos="fade-up" data-aos-delay="150">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>NIDN</th>
                <th>Prodi</th>
                <th>Username</th>
                <th>Password</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dosen as $d)
            <tr data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                <td data-label="#">{{ $loop->iteration }}</td>
                <td data-label="Foto">
                    <div class="foto-wrapper">
                        <img src="{{ $d->getFotoUrlAttribute() }}" alt="Foto">
                    </div>
                </td>
                <td data-label="Nama">{{ $d->nama }}</td>
                <td data-label="NIDN">{{ $d->nidn }}</td>
                <td data-label="Prodi">{{ $d->kaprodi }}</td>
                <td data-label="Username">{{ $d->user->username }}</td>
                <td data-label="Password">
                    @php
                        $plain = $d->user->password_plain ?? '123';
                        $length = strlen($plain);
                        $strength = $length < 4 ? 'weak' : ($length < 8 ? 'medium' : 'strong');
                    @endphp
                    <span class="password-badge password-{{ $strength }}" onclick="togglePassword(this, '{{ $plain }}')">******</span>
                </td>
                <td data-label="Dibuat">{{ $d->created_at ? $d->created_at->format('d-m-Y H:i') : '-' }}</td>
                <td data-label="Aksi">
                    <a href="{{ route('dosen.edit', $d->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
                    <form action="{{ route('dosen.destroy', $d->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mb-1" 
                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="empty-message" data-aos="fade-down" data-aos-delay="150">
    Belum ada data dosen.
</div>
@endif
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 700, once: true });

function togglePassword(el, plain) {
    if(el.innerText === '******'){
        el.innerText = plain;
    } else {
        el.innerText = '******';
    }
}
</script>
@endpush
