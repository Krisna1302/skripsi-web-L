@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
@push('styles')
<style>
    /* ==============================
       Profile Card Section
       ============================== */
    .profile-card {
        background: linear-gradient(145deg, #2a2b3d, #262636);
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 35px;
    }

    .profile-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .profile-card img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #4a90e2;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .profile-card img:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 15px rgba(74,144,226,0.6);
    }

    .profile-info h3 {
        margin-bottom: 8px;
        color: #f1f1f1;
        font-weight: 700;
        font-size: 1.8rem;
    }

    .profile-info p {
        margin: 3px 0;
        color: #d1d1e0;
        font-size: 0.95rem;
    }

    .profile-quote {
        margin-top: 12px;
        font-style: italic;
        color: #aab2c3;
        background: rgba(255,255,255,0.05);
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 0.9rem;
    }

    /* ==============================
       History Card Container
       ============================== */
    .history-card {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        background: rgba(42,43,61,0.85);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
    }

    /* ==============================
       Individual History Box
       ============================== */
    .history-box {
        background: #2a2b3d;
        border-radius: 12px;
        padding: 18px 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        /* Shadow kiri dan bawah */
        box-shadow: -6px 6px 15px rgba(0,0,0,0.3),
                    -3px 3px 10px rgba(60,60,80,0.2);
    }

    /* ==============================
       Soft Shimmer Effect
       ============================== */
    .history-box::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        pointer-events: none;
        transform: rotate(25deg);
        animation: shimmerSoft 12s infinite linear;
    }

    @keyframes shimmerSoft {
        0% { transform: rotate(25deg) translateX(-100%); }
        100% { transform: rotate(25deg) translateX(100%); }
    }

    /* ==============================
       Hover Effect for History Box
       ============================== */
    .history-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.4),
                    0 0 12px rgba(74,144,226,0.2);
    }

    /* ==============================
       Status Styles & Animations
       ============================== */
    .status-menunggu { 
        color: #f1c40f; 
        font-weight: 600;
        animation: pulse 2s infinite;
    }
    .status-diterima { 
        color: #2ecc71; 
        font-weight: 600;
        animation: slideUp 0.5s ease forwards;
    }
    .status-ditolak { 
        color: #e74c3c; 
        font-weight: 600;
        animation: shake 0.5s;
    }

    @keyframes pulse {
        0% { opacity: 0.6; }
        50% { opacity: 1; }
        100% { opacity: 0.6; }
    }

    @keyframes slideUp {
        0% { transform: translateY(20px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-5px); }
        40%, 80% { transform: translateX(5px); }
    }

    /* ==============================
       Timestamp Text
       ============================== */
    .history-box .timestamp {
        font-size: 13px;
        color: #aaa;
        margin-top: 6px;
    }

    /* ==============================
       Highlight Judul Pengajuan
       ============================== */
    .history-box strong {
        display: inline-block;
        background: rgba(74,144,226,0.15);
        padding: 2px 8px;
        border-radius: 6px;
        margin-bottom: 6px;
    }
</style>
@endpush

<div data-aos="fade-up">
    @if($mahasiswa)
        <!-- ==============================
             Profile Card
             ============================== -->
        <div class="profile-card" data-aos="fade-down" data-aos-duration="800">
            <img src="{{ $mahasiswa->foto_url }}" alt="Foto Profil">
            <div class="profile-info">
                <h3>{{ $mahasiswa->nama }}</h3>
                <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
                <p><strong>Prodi:</strong> {{ $mahasiswa->prodi }}</p>

                @if($random_quote)
                    <div class="profile-quote">"{{ $random_quote }}"</div>
                @endif
            </div>
        </div>

        <!-- ==============================
             History Card Container
             ============================== -->
        <div class="history-card" data-aos="fade-up" data-aos-delay="150">
            @if($mahasiswa->pengajuan->isEmpty())
                <p class="text-warning">Belum ada pengajuan judul skripsi.</p>
            @else
                <!-- ==============================
                     Individual History Box
                     ============================== -->
                @foreach($mahasiswa->pengajuan as $p)
                    <div class="history-box">
                        <strong>{{ $p->judul }}</strong>
                        Status:
                        @php $s = strtolower($p->status); @endphp
                        @if($s === 'menunggu')
                            <span class="status-menunggu">Menunggu</span>
                        @elseif($s === 'diterima')
                            <span class="status-diterima">Diterima</span>
                        @elseif($s === 'ditolak')
                            <span class="status-ditolak">Ditolak</span>
                        @else
                            <span>{{ $p->status }}</span>
                        @endif
                        <div class="timestamp">
                            Dikirim: {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y, H:i') }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @else
        <!-- ==============================
             Error / Data Not Found
             ============================== -->
        <div class="card bg-dark text-white shadow-sm p-4">
            <h2 class="card-title text-danger">Data Mahasiswa Tidak Ditemukan!</h2>
            <p class="mt-3">Mohon hubungi administrator untuk memastikan data profil Anda sudah terdaftar.</p>
            <form action="{{ route('logout') }}" method="POST" class="d-inline mt-4">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 700,
    once: true
  });
</script>
@endpush
@endsection
