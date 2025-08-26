@extends('layouts.app')

@section('title', 'Data Pengajuan')

@section('content')
<!-- ==============================
     Judul Halaman
     ============================== -->
<h2 data-aos="fade-down">Data Pengajuan Judul Skripsi</h2>

<!-- ==============================
     Notifikasi Sukses
     ============================== -->
@if(session('success'))
  <div class="alert alert-success" data-aos="fade-down">{{ session('success') }}</div>
@endif

@push('styles')
<style>
/* ==============================
   Filter Card
   ============================== */
.filter-card {
    background: rgba(42,43,61,0.8);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    margin-bottom: 20px;
}
.filter-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.4);
}
.filter-card label { font-weight: 500; color: #f1f1f1; }
.filter-card .form-control {
    background: #fff; color: #000; border: 1px solid rgba(0,0,0,0.2);
}
.filter-card .form-control:focus {
    background: #fff; color: #000;
    border-color: #4e9af1;
    box-shadow: 0 0 5px rgba(78,154,241,0.3);
}
.filter-card .btn-primary { background-color: #007bff; border: none; color: #fff; }
.filter-card .btn-primary:hover { background-color: #0069d9; }
.filter-card .btn-secondary { background-color: #6c757d; border: none; color: #fff; }
.filter-card .btn-secondary:hover { background-color: #5a6268; }

/* ==============================
   Card Pengajuan
   ============================== */
.card-pengajuan {
  background: rgba(42,43,61,0.7);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card-pengajuan:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.4);
}
.card-pengajuan h5 { margin-bottom: 10px; color: #fff; }
.card-pengajuan p { margin: 3px 0; color: #ddd; font-size: 0.9rem; }
.card-footer { display: flex; justify-content: flex-end; gap: 8px; margin-top: 10px; }

/* ==============================
   Badge Status
   ============================== */
.badge-status {
  padding: 0 14px; border-radius: 30px; font-weight: 500; font-size: 0.85rem;
  display: inline-block; transition: transform 0.2s ease-in-out;
}
.badge-status:hover { transform: scale(1.08); }

/* Flat badges card */
.status-menunggu { background: none; color: #d4c96f; font-weight: bold; }
.status-diterima { background: none; color: #81f781; font-weight: bold; }
.status-ditolak { background: none; color: #f18b8b; font-weight: bold; }

/* Modal badge warna penuh */
.modal-badge { padding: 0 12px; border-radius: 12px; color: #fff; font-weight: bold; display: inline-block; }
.modal-badge.status-menunggu { color: #d4c96f; }
.modal-badge.status-diterima { background-color: #81f781; }
.modal-badge.status-ditolak { background-color: #f18b8b; }

/* Tombol card */
.btn-view, .btn-tindak {
  font-size: 0.8rem; border-radius: 5px; transition: background 0.3s ease-in-out;
}
.btn-view { background-color: #6c757d; color:#fff; }
.btn-view:hover { background-color: #5a6268; }
.btn-tindak { background-color: #17a2b8; color:#fff; }
.btn-tindak:hover { background-color: #138496; }

/* Tombol modal */
.btn-acc { background-color: #28a745; color:#fff; }
.btn-acc:hover { background-color: #218838; }
.btn-reject { background-color: #dc3545; color:#fff; }
.btn-reject:hover { background-color: #c82333; }

</style>
@endpush

<!-- ==============================
     Filter Form
     ============================== -->
<div class="filter-card" data-aos="fade-down" data-aos-delay="50">
  <form method="GET" action="{{ route('pengajuan.data') }}">
    <div class="row g-2">
      <div class="col-md-3">
        <label>Nama Mahasiswa</label>
        <select name="nama" class="form-control">
          <option value="">Semua</option>
          @foreach($nama_mahasiswa as $nama)
            <option value="{{ $nama }}" {{ request('nama')==$nama?'selected':'' }}>{{ $nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label>NIM</label>
        <input type="text" name="nim" value="{{ request('nim') }}" class="form-control" placeholder="Ketik NIM">
      </div>
      <div class="col-md-3">
        <label>Prodi</label>
        <select name="bidang" class="form-control">
          <option value="">Semua</option>
          @foreach($bidang_mahasiswa as $bidang)
            <option value="{{ $bidang }}" {{ request('bidang')==$bidang?'selected':'' }}>{{ $bidang }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label>Tanggal Pengajuan</label>
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
      </div>
    </div>
    <div class="mt-2">
      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="{{ route('pengajuan.data') }}" class="btn btn-secondary">Reset</a>
    </div>
  </form>
</div>

<!-- ==============================
     Card Layout Pengajuan
     ============================== -->
<div class="row">
  @forelse($pengajuans as $row)
    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 50 + $loop->index*50 }}">
      <div class="card-pengajuan">
        <h5>{{ $row->judul }}</h5>
        <p><strong>Mahasiswa:</strong> {{ $row->mahasiswa->nama ?? '-' }}</p>
        <p><strong>NIM:</strong> {{ $row->mahasiswa->nim ?? '-' }}</p>
        <p><strong>Prodi:</strong> {{ $row->bidang }}</p>
        <p><strong>Pembimbing:</strong> {{ $row->pembimbing }}</p>
        <p><strong>Status:</strong> 
          <span class="badge-status {{ $row->status=='Menunggu'?'status-menunggu':($row->status=='Diterima'?'status-diterima':'status-ditolak') }}">
            {{ $row->status }}
          </span>
        </p>
        <p><strong>Tanggal:</strong> {{ $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') : '-' }}</p>
        <div class="card-footer">
          <a href="{{ route('pengajuan.lihat-file.dosen', $row->id) }}" target="_blank" class="btn btn-view btn-sm">Lihat Proposal</a>
          <button type="button" class="btn btn-tindak btn-sm"
        data-id="{{ $row->id }}"
        data-nama="{{ $row->mahasiswa->nama }}"
        data-judul="{{ $row->judul }}"
        data-deskripsi="{{ $row->deskripsi }}">
  Tindak
</button>

        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-center text-warning fw-bold py-4">
      Belum ada pengajuan judul skripsi saat ini.
    </div>
  @endforelse
</div>

<!-- ==============================
     Modal Global Tindak Pengajuan
     ============================== -->
<div class="modal fade" id="tindakModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="tindakForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tindak Pengajuan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
  <p><strong>Nama:</strong> <span id="modalNama"></span></p>
  <p><strong>Judul:</strong> <span id="modalJudul"></span></p>
  <p><strong>Deskripsi:</strong></p>
  <p id="modalDeskripsi" style="white-space: pre-wrap; color: #333;"></p>
  <p><strong>Status:</strong> 
    <span id="modalStatus" class="modal-badge"></span>
  </p>
  <textarea name="komentar" rows="4" class="form-control" placeholder="Tulis komentar (opsional)..."></textarea>
</div>

        <div class="modal-footer d-flex flex-column flex-md-row gap-2">
          <button type="submit" name="status" value="Diterima" class="btn btn-acc">Setujui</button>
          <button type="submit" name="status" value="Ditolak" class="btn btn-reject">Tolak</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"/>
<script>
AOS.init({ duration: 700, once: true });

document.addEventListener("DOMContentLoaded", () => {
  const tindakModal = new bootstrap.Modal(document.getElementById('tindakModal'));
  const form = document.getElementById('tindakForm');

  // Event tiap tombol Tindak
  document.querySelectorAll('.btn-tindak').forEach(btn => {
    btn.addEventListener('click', () => {
  let id = btn.dataset.id;
  let nama = btn.dataset.nama;
  let judul = btn.dataset.judul;
  let deskripsi = btn.dataset.deskripsi;
  let status = btn.closest('.card-pengajuan').querySelector('.badge-status').innerText;

  document.getElementById('modalNama').innerText = nama;
  document.getElementById('modalJudul').innerText = judul;
  document.getElementById('modalDeskripsi').innerText = deskripsi || '-';

  // Set badge warna sesuai status
  const modalStatus = document.getElementById('modalStatus');
  modalStatus.innerText = status;
  modalStatus.className = 'modal-badge';
  if(status == 'Menunggu') modalStatus.classList.add('status-menunggu');
  else if(status == 'Diterima') modalStatus.classList.add('status-diterima');
  else if(status == 'Ditolak') modalStatus.classList.add('status-ditolak');

  form.action = "{{ url('/pengajuan/status') }}/" + id;
  tindakModal.show();
});
  });
});
</script>
@endpush
@endsection
