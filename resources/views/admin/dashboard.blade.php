@extends('layouts.app')

@section('title', 'Dashboard Admin')

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
    color: #f1f1f1; 
    margin-bottom: 20px; 
    animation: fadeInDown 1s ease; 
}

/* ==============================
   Card Animations
   ============================== */
.card {
    background-color: #2a2a40;
    border: none;
    border-radius: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.5);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
    animation-delay: calc(var(--i) * 0.1s);
}
.card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 12px 25px rgba(0,123,255,0.4);
}
.card h6 {
    font-size: 0.9rem;
    color: #cfcfcf;
}
.card h3 {
    font-weight: bold;
    margin: 0;
}

/* ==============================
   Table Glassy Style
   ============================== */
.table-responsive { overflow-x: auto; }
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
    transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
    animation-delay: calc(var(--i) * 0.05s);
}
.table tbody tr:hover {
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 8px 25px rgba(0,123,255,0.4);
    background: rgba(42,43,61,0.75);
}
.table tbody td {
    background: transparent;
    padding: 14px 12px;
    vertical-align: middle;
    color: #f1f1f1;
    text-align: center;
}

/* ==============================
   Responsive / Mobile Friendly
   ============================== */
@media (max-width: 767px) {
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    .col-md-3, .col-md-2, .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 15px;
    }

    /* Table jadi list style */
    .table thead {
        display: none;
    }
    .table tbody,
    .table tr,
    .table td {
        display: block;
        width: 100%;
        text-align: left; /* pastikan isi rata kiri */
    }
    .table tr {
        margin-bottom: 15px;
        border-radius: 12px;
        overflow: hidden;
    }

    .table tbody td {
        display: flex;
        align-items: flex-start;
        padding: 10px;
        gap: 12px; /* tambah jarak label ↔ isi */
    }

    .table td::before {
        content: attr(data-label);
        flex: 0 0 100px; /* lebar tetap label */
        font-weight: 600;
        color: #00bcd4;
        text-align: left; /* label tetap rata kiri */
    }

    .table td[data-label="Judul"] {
        max-width: 100%;
        white-space: normal;    /* biar bisa turun ke bawah */
        word-wrap: break-word;
        overflow: hidden;
        text-align: left;       /* isi rata kiri */
    }

    .table td:last-child {
        border-bottom: none;
    }

    .chart-container {
        width: 100% !important;
        height: auto !important;
    }

    .table tbody tr {
        background-color: #242437;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 12px; /* jarak antar row */
        border: 1px solid #3e3e50; /* garis pemisah full */
    }

    .table tbody tr td {
        border: none !important; /* hapus border default */
    }
}


/* ==============================
   Status Badge Pop-in
   ============================== */
.status-badge { 
    font-weight: 600; 
    padding: 6px 14px; 
    border-radius: 20px; 
    display: inline-block; 
    font-size: 0.85rem;
    text-align: center;
    transition: all 0.3s ease, transform 0.3s ease;
    opacity: 0;
    animation: popIn 0.6s ease forwards;
}
.status-badge:hover { transform: scale(1.1); }

.status-menunggu { background: rgba(255,193,7,0.85); color:#fff; box-shadow: 0 0 8px rgba(255,193,7,0.6);}
.status-diterima { background: rgba(40,167,69,0.85); color:#fff; box-shadow: 0 0 8px rgba(40,167,69,0.6);}
.status-ditolak { background: rgba(220,53,69,0.85); color:#fff; box-shadow: 0 0 8px rgba(220,53,69,0.6);}
.status-dikembalikan { background: rgba(0,123,255,0.85); color:#fff; box-shadow: 0 0 8px rgba(0,123,255,0.6);}

/* Empty State */
.empty-message { 
    text-align: center; 
    padding: 40px; 
    font-size: 1.1rem; 
    color: #ffc107; 
    background: rgba(42,43,61,0.6); 
    backdrop-filter: blur(12px);
    border-radius: 12px; 
    animation: fadeIn 1s ease;
}

/* ==============================
   Keyframes
   ============================== */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes popIn {
    0% { opacity: 0; transform: scale(0.5); }
    80% { transform: scale(1.05); }
    100% { opacity: 1; transform: scale(1); }
}
</style>
@endpush

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">📊 Dashboard Admin</h2>

    {{-- Ringkasan --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center p-3" style="--i:1">
                <h6>Mahasiswa</h6>
                <h3 class="text-primary">{{ $jumlahMahasiswa }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3" style="--i:2">
                <h6>Dosen</h6>
                <h3 class="text-info">{{ $jumlahDosen }}</h3>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center p-3" style="--i:3">
                <h6>Diterima</h6>
                <h3 class="text-success">{{ $pengajuanStats['Diterima'] }}</h3>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center p-3" style="--i:4">
                <h6>Menunggu</h6>
                <h3 class="text-warning">{{ $pengajuanStats['Menunggu'] }}</h3>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center p-3" style="--i:5">
                <h6>Ditolak</h6>
                <h3 class="text-danger">{{ $pengajuanStats['Ditolak'] }}</h3>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3" style="--i:6">
                <h6 class="text-center">Jumlah Mahasiswa per Prodi</h6>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3" style="--i:7">
                <h6 class="text-center">Status Pengajuan</h6>
                <div class="chart-container" style="height:250px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel pengajuan terbaru --}}
    <div class="card p-3" style="--i:8">
        <h6>Pengajuan Terbaru</h6>
        @if(count($recentPengajuan) > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Mahasiswa</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentPengajuan as $k => $p)
                <tr style="--i:{{ $k }}">
                    <td data-label="Mahasiswa">{{ $p->mahasiswa->nama }}</td>
                    <td data-label="Judul">{{ $p->judul }}</td>
                    <td data-label="Status">
                        @if($p->status == 'Diterima')
                            <span class="status-badge status-diterima">Diterima</span>
                        @elseif($p->status == 'Ditolak')
                            <span class="status-badge status-ditolak">Ditolak</span>
                        @elseif($p->status == 'Menunggu')
                            <span class="status-badge status-menunggu">Menunggu</span>
                        @else
                            <span class="status-badge status-dikembalikan">{{ $p->status }}</span>
                        @endif
                    </td>
                    <td data-label="Tanggal">{{ $p->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="empty-message">Belum ada pengajuan terbaru.</div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Bar Chart
const ctxBar = document.getElementById('barChart').getContext('2d');
new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: {!! json_encode($prodiCounts->keys()) !!},
        datasets: [{
            label: 'Jumlah Mahasiswa',
            data: {!! json_encode($prodiCounts->values()) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderRadius: 10
        }]
    },
    options: {
        responsive: true,
        animation: { duration: 1500, easing: 'easeOutBounce' },
        plugins: { legend: { labels: { color: '#fff' } } },
        scales: {
            x: { ticks: { color: '#fff' } },
            y: { ticks: { color: '#fff' } }
        }
    }
});

// Pie Chart
const ctxPie = document.getElementById('pieChart').getContext('2d');
new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: ['Menunggu','Diterima','Ditolak'],
        datasets: [{
            data: [
                {{ $pengajuanStats['Menunggu'] ?? 0 }},
                {{ $pengajuanStats['Diterima'] ?? 0 }},
                {{ $pengajuanStats['Ditolak'] ?? 0 }}
            ],
            backgroundColor: [
                'rgba(255,193,7,0.8)',
                'rgba(40,167,69,0.8)',
                'rgba(220,53,69,0.8)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { animateScale: true, animateRotate: true },
        plugins: { legend: { labels: { color: '#fff' } } },
        cutout: '65%'
    }
});
</script>
@endpush
