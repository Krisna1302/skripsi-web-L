@extends('layouts.app')

@section('title', 'Pengajuan Mahasiswa')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
/* Container */
.container { max-width: 950px; margin: auto; }

/* Filter Card */
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

/* Cards */
.card {
    background-color: #1f1f2f;
    color: #f1f1f1;
    border-radius: 15px;
    margin-bottom: 15px;
    transition: transform 0.3s, box-shadow 0.3s, opacity 0.4s;
    opacity: 0;
    transform: translateY(20px);
}
.card.show { opacity: 1; transform: translateY(0); }

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    padding: 15px;
    transition: background-color 0.3s;
}
.card-header:hover { background-color: #2a2a3b; }
.card-header img {
    width: 50px; height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
}

.card-header .meta-left { display: flex; align-items: center; gap: 12px; }

/* Deskripsi preview satu baris di header */
.card-header .preview {
    display: block;
    color: #cfcfcf;
    font-size: 0.85rem;
    margin-top: 4px;
    max-width: 520px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Card body */
.card-body {
    padding: 15px 20px;
    display: none;
    animation: slideDown 0.3s ease forwards;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Badge */
.badge-status {
    font-weight: 600;
    padding: 0.45em 0.75em;
    font-size: 0.85rem;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.badge-status:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

/* Buttons */
.card-body .btn-group form,
.card-body .btn-group a { display: inline-block; margin-right: 5px; }
.card-body .btn {
    border-radius: 8px;
    padding: 5px 14px;
    font-size: 0.85rem;
    transition: all 0.25s ease;
}
.card-body .btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 16px rgba(0,0,0,0.35);
}
.btn-success i,
.btn-danger i,
.btn-primary i,
.btn-secondary i { margin-right: 4px; }

/* Toggle Icon */
.toggle-icon { transition: transform 0.3s ease; }
.toggle-open { transform: rotate(180deg); }

/* Optional: batasi deskripsi di card body jadi maksimal 2 baris (aktifkan kalau mau)
.card-body .deskripsi {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
*/
</style>
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4" data-aos="fade-down">Daftar Pengajuan</h2>

    <!-- Filter Form -->
    <div class="filter-card" data-aos="fade-up" data-aos-delay="50">
        <form method="GET" action="{{ route('pengajuan.status') }}">
            <div class="row g-2">
                <div class="col-md-3">
                    <label>Nama Mahasiswa</label>
                    <select name="nama" class="form-control">
                        <option value="">Semua</option>
                        @foreach(($nama_mahasiswa ?? []) as $nama)
                        <option value="{{ $nama }}" {{ request('nama') == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label>NIM</label>
                    <input type="text" name="nim" value="{{ request('nim') }}" class="form-control" placeholder="Ketik NIM">
                </div>
                <div class="col">
                    <label>Prodi</label>
                    <select name="prodi" class="form-control">
                        <option value="">Semua</option>
                        @foreach(($prodi_mahasiswa ?? []) as $prodi)
                        <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col">
                    <label>Urutkan Tanggal</label>
                    <select name="sort" class="form-control">
                        <option value="desc" {{ ($sort ?? 'desc') == 'desc' ? 'selected' : '' }}>Terbaru → Terlama</option>
                        <option value="asc" {{ ($sort ?? '') == 'asc' ? 'selected' : '' }}>Terlama → Terbaru</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('pengajuan.status') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row" data-aos="fade-up">
        @forelse($pengajuan as $p)
        @php $status = strtolower($p->status); @endphp
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between" onclick="toggleCardBody(this)">
                    <div class="meta-left">
                        <img src="{{ $p->mahasiswa->getFotoUrlAttribute() }}" alt="Foto">
                        <div>
                            <strong>{{ $p->mahasiswa->nama }}</strong> | {{ $p->mahasiswa->nim }}<br>
                            <small>{{ $p->mahasiswa->prodi }}</small><br>
                            <small class="fst-italic">Judul: {{ $p->judul }}</small>
                            <small class="preview" title="{{ strip_tags($p->deskripsi ?? '-') }}">
                                {{ \Illuminate\Support\Str::limit(strip_tags($p->deskripsi ?? '-'), 100) }}
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge
                            @if($status == 'menunggu') bg-warning text-dark
                            @elseif($status == 'diterima') bg-success
                            @else bg-danger @endif
                            badge-status me-2">{{ ucfirst($status) }}</span>
                        <i class="bi bi-chevron-down toggle-icon"></i>
                    </div>
                </div>

                <div class="card-body">
                    <p><strong>File:</strong>
                        @if($p->file)
                        <a href="{{ asset('uploads/' . $p->file) }}" target="_blank">
                            <i class="bi bi-file-earmark-text"></i> Lihat File
                        </a>
                        @else Tidak ada @endif
                    </p>
                    <p><strong>Deskripsi:</strong><br>{{ $p->deskripsi ?? '-' }}</p>
                    <p><strong>Komentar Dosen:</strong><br>{{ $p->komentar ?? '-' }}</p>
                    <p><strong>Tanggal Pengajuan:</strong> {{ $p->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">Belum ada pengajuan.</p>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    AOS.init({ duration: 700, once: true });

    // Animate card fade-in
    const cards = document.querySelectorAll('.card');
    cards.forEach((c, i) => setTimeout(() => c.classList.add('show'), i*100));
});

function toggleCardBody(header) {
    const body = header.nextElementSibling;
    const icon = header.querySelector('.toggle-icon');
    if (body.style.display === "block") {
        body.style.display = "none";
        icon.classList.remove('toggle-open');
    } else {
        body.style.display = "block";
        icon.classList.add('toggle-open');
        body.style.animation = "slideDown 0.3s ease forwards";
    }
}
</script>
@endpush
