@extends('layouts.app')

@section('title', 'Profil Dosen')

@section('content')
@push('styles')
<style>
/* ==============================
   Card Profil
   ============================== */
.profile-card {
    max-width: 500px;
    margin: 30px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    background: #2a2b3d;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.profile-card::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, rgba(74,144,226,0.2), rgba(255,255,255,0.1));
    transform: rotate(25deg);
    pointer-events: none;
}
.profile-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    transform: translateY(-5px);
}

/* ==============================
   Heading
   ============================== */
.profile-card h3 {
    text-align: center;
    margin-bottom: 25px;
    color: #f1f1f1;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* ==============================
   Foto Profil
   ============================== */
.profile-photo {
    display: block;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 15px auto;
    border: 3px solid #4a90e2;
    transition: all 0.4s ease;
}

/* ==============================
   Form
   ============================== */
.form-label { font-weight: 500; color: #d1d1e0; }
.form-control {
    border-radius: 8px;
    background-color: #3b3c55;
    color: #f1f1f1;
    border: 1px solid #4a4c6b;
    transition: all 0.3s ease;
}
.form-control:focus {
    background-color: #3b3c55;
    color: #f1f1f1;
    border-color: #4a90e2;
    box-shadow: 0 0 8px rgba(74,144,226,0.5);
}

/* ==============================
   Tombol Simpan
   ============================== */
.btn-primary {
    display: block;
    width: 100%;
    border-radius: 8px;
    padding: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
    background-color: #4a90e2;
    border: none;
    color: #fff;
    box-shadow: 0 3px 6px rgba(0,0,0,0.2);
}
.btn-primary:hover {
    background-color: #357ab8;
    box-shadow: 0 5px 12px rgba(0,0,0,0.3);
    transform: translateY(-2px);
}

/* ==============================
   Alert Success
   ============================== */
.alert-success {
    text-align: center;
    font-weight: 500;
    color: #d4edda;
    background-color: #2b3a3b;
    border: 1px solid #3a5a3b;
    border-radius: 6px;
    padding: 10px;
    margin-bottom: 15px;
    animation: fadeIn 0.8s ease;
}
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(-10px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>
@endpush

<!-- ==============================
     Profil Card
     ============================== -->
<div class="card profile-card" data-aos="fade-up" data-aos-duration="600">
    <h3>Edit Profil Dosen</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('dosen.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 text-center" data-aos="fade-up" data-aos-delay="200">
            <label for="foto" class="form-label">Foto Profil</label><br>
            <img src="{{ asset('assets/img/dosen/' . ($dosen->foto ?? 'default.png')) }}" 
                 alt="Foto Profil" class="profile-photo" data-aos="fade-up" data-aos-duration="600" data-aos-delay="250">
            <input type="file" name="foto" id="foto" class="form-control mt-2" data-aos="fade-up" data-aos-delay="300">
        </div>

        <button type="submit" class="btn btn-primary" data-aos="fade-up" data-aos-delay="350">Simpan</button>
    </form>
</div>

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
    });
</script>
@endpush
@endsection
