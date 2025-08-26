@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

<style>
.container { max-width: 720px; margin: auto; }

.glass-card {
    backdrop-filter: blur(10px);
    background-color: rgba(30,30,40,0.95);
    border-radius: 20px;
    padding: 30px 35px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.glass-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(78,154,241,0.35);
}

h2 { 
    text-align: center; 
    margin-bottom: 30px; 
    font-weight: 700; 
    color: #f1f1f1; 
}

.input-group {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.input-group:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(78,154,241,0.2);
}

.input-group-text {
    background-color: #2a2b3d !important;
    border: 1px solid #555 !important;
    color: #f1f1f1 !important;
}

/* Warna icon bootstrap (i / ::before / svg) */
.input-group-text i,
.input-group-text i::before,
.input-group-text svg {
    color: #f1f1f1 !important;
    fill: #f1f1f1 !important;
}

.form-control {
    background-color: #1f1f2f;
    color: #fff;
    border: 1px solid #555;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4e9af1;
    box-shadow: 0 0 8px rgba(78,154,241,0.5);
    background-color: #252536;
    color: #fff;
}

::placeholder { color: #aaa; opacity: 1; }

.btn-primary {
    background: linear-gradient(90deg,#4e9af1,#6aa8f9);
    border: none;
    width: 100%;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 1.05rem;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s, background 0.3s;
}

.btn-primary:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 20px rgba(78,154,241,0.45);
    background: linear-gradient(90deg,#6aa8f9,#4e9af1);
}

/* Biar placeholder kelihatan putih */
.form-control::placeholder {
    color: #ddd !important; /* bisa juga #f1f1f1 kalau mau lebih putih */
    opacity: 1 !important;
}

</style>
@endpush

@section('content')
<div class="container" data-aos="fade-up">
    <h2 data-aos="fade-down" data-aos-duration="800">Tambah Mahasiswa</h2>

    <div class="glass-card" data-aos="fade-up" data-aos-delay="100">
        <form action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf

            <!-- Username -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="150">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="200">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
            </div>

            <!-- Nama -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="250">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>
            </div>

            <!-- NIM -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="300">
                <label class="form-label">NIM</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM" required>
                </div>
            </div>

            <!-- Prodi -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="350">
                <label class="form-label">Prodi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-book-half"></i></span>
                    <input type="text" name="prodi" class="form-control" placeholder="Masukkan program studi" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-2" data-aos="zoom-in" data-aos-delay="400">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('[data-aos]').forEach(el => {
        el.classList.add('aos-init', 'aos-animate');
    });

    AOS.init({
        duration: 700,
        once: true
    });
});
</script>
@endpush
