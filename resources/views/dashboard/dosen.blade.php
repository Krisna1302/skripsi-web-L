@extends('layouts.app')

@section('content')
@push('styles')
<style>
    /* ==============================
       Profile Section
       ============================== */
    .profile-section {
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
        padding: 25px;
        background: linear-gradient(145deg, #2a2b3d, #262636);
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        margin-bottom: 35px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .profile-section img {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #4a90e2;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .profile-section img:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 15px rgba(74,144,226,0.6);
    }

    .profile-section .info h2 {
        margin-bottom: 10px;
        font-size: 1.9rem;
        color: #f1f1f1;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .profile-section .extra p {
        margin: 5px 0;
        color: #d1d1e0;
        font-size: 0.95rem;
    }

    /* ==============================
       Ringkasan Pengajuan (Summary Card)
       ============================== */
    .summary-card {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 35px;
    }

    .summary-card div {
        flex: 1 1 150px;
        text-align: center;
        padding: 25px 15px;
        border-radius: 12px;
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
        cursor: default;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* ==============================
       Shimmer Animation for Summary Card
       ============================== */
    .summary-card div::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, rgba(255,255,255,0.05), rgba(255,255,255,0.0));
        transform: rotate(45deg);
        animation: shimmer 3s infinite alternate;
        pointer-events: none;
    }

    @keyframes shimmer {
        0% { transform: rotate(45deg) translateX(-100%); }
        100% { transform: rotate(45deg) translateX(100%); }
    }

    .summary-card div:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    /* ==============================
       Warna Status
       ============================== */
    .summary-card .waiting { background-color: #f39c12; }
    .summary-card .accepted { background-color: #27ae60; }
    .summary-card .rejected { background-color: #c0392b; }

    .summary-card .count {
        font-size: 1.7rem;
        font-weight: 700;
        margin-top: 8px;
    }
</style>
@endpush

<!-- ==============================
     Profile Section
     ============================== -->
<div class="profile-section" data-aos="fade-down" data-aos-duration="900">
    <img src="{{ asset('assets/img/dosen/' . $dosen->foto) }}" alt="Foto Profil Dosen">
    <div class="info">
        <h2>Selamat datang, {{ htmlspecialchars($dosen->nama) }}!</h2>
        <div class="extra">
            <p><strong>NIDN:</strong> {{ htmlspecialchars($dosen->nidn) }}</p>
            <p><strong>Dosen Penasihat:</strong> {{ htmlspecialchars($dosen->kaprodi) }}</p>
        </div>
    </div>
</div>

<!-- ==============================
     Ringkasan Pengajuan
     ============================== -->
<div class="summary-card">
    <div class="waiting" data-aos="fade-up" data-aos-delay="100">
        Menunggu
        <div class="count">{{ $jumlah_menunggu ?? 0 }}</div>
    </div>
    <div class="accepted" data-aos="fade-up" data-aos-delay="200">
        Diterima
        <div class="count">{{ $jumlah_diterima ?? 0 }}</div>
    </div>
    <div class="rejected" data-aos="fade-up" data-aos-delay="300">
        Ditolak
        <div class="count">{{ $jumlah_ditolak ?? 0 }}</div>
    </div>
</div>

<!-- ==============================
     AOS Animate
     ============================== -->
@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"/>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        easing: 'ease-in-out',
        once: true
    });
</script>
@endpush
@endsection
