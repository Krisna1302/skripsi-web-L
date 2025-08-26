@extends('layouts.app')

@section('title', 'Ajukan Skripsi')

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
    background-color: #2a2b3d;
    border: 1px solid #555;
    color: #ddd;
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

textarea.form-control.typing { min-height: 100px; }

select.form-control {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    color: #fff;
    background-color: #1f1f2f;
    border: 1px solid #555;
    padding-left: 10px;
}

select.form-control:focus {
    border-color: #4e9af1;
    box-shadow: 0 0 8px rgba(78,154,241,0.5);
    background-color: #252536;
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

.alert-danger {
    background-color: rgba(90,46,46,0.85);
    color: #f18b8b;
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 15px;
}
.form-control::placeholder {
    color: #ddd !important; /* bisa juga #f1f1f1 kalau mau lebih putih */
    opacity: 1 !important;
}
#filePreview { margin-top: 5px; font-size: 0.95rem; color: #ccc; transition: opacity 0.4s ease; }
#filePreview a { color: #4e9af1; text-decoration: underline; }
</style>
@endpush

@section('content')
<div class="container" data-aos="fade-up">
    <h2 data-aos="fade-down" data-aos-duration="800">Form Pengajuan Judul Skripsi</h2>

    <div class="glass-card" data-aos="fade-up" data-aos-delay="100">
        @if ($errors->any())
            <div class="alert alert-danger" data-aos="fade-in" data-aos-delay="150">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama & NIM -->
            <div class="row g-3 mb-3" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="nama" class="form-control" value="{{ $mahasiswa->nama }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">NIM</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <input type="text" name="nim" class="form-control" value="{{ $mahasiswa->nim }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Judul -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="250">
                <label class="form-label">Judul Skripsi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                    <textarea name="judul" class="form-control typing @error('judul') is-invalid @enderror" placeholder="Masukkan judul skripsi Anda" required>{{ old('judul') }}</textarea>
                </div>
                @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="300">
                <label class="form-label">Deskripsi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <textarea name="deskripsi" class="form-control typing @error('deskripsi') is-invalid @enderror" placeholder="Tulis deskripsi singkat mengenai skripsi Anda" rows="3" required>{{ old('deskripsi') }}</textarea>
                </div>
                @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Bidang -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="350">
                <label class="form-label">Bidang</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-book-half"></i></span>
                    <input type="text" name="bidang" class="form-control" value="{{ $mahasiswa->prodi }}" readonly>
                </div>
            </div>

            <!-- Dosen Pembimbing -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="400">
                <label class="form-label">Dosen Pembimbing</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                    <select name="pembimbing" class="form-control @error('pembimbing') is-invalid @enderror" id="selectDosen" onchange="updateNidn(this)" required>
                        <option value="" disabled selected>Pilih dosen...</option>
                        @foreach($dosen as $d)
                            <option value="{{ $d->nama }}" data-nidn="{{ $d->nidn }}" {{ old('pembimbing') == $d->nama ? 'selected' : '' }}>
                                {{ $d->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="nidn" id="nidnField" value="{{ old('nidn') }}">
                @error('pembimbing') <small class="text-danger">{{ $message }}</small> @enderror
                @error('nidn') <small class="text-danger mt-2">NIDN tidak valid.</small> @enderror
            </div>

            <!-- Upload File -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="450">
                <label class="form-label">Upload Proposal (PDF / TXT)</label>
                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.txt" id="fileUpload" required>
                <div id="filePreview" data-aos="fade-in" data-aos-delay="500">
                    <i class="bi bi-file-earmark-text"></i> <span id="fileName">Belum ada file</span>
                </div>
                @error('file') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-2" data-aos="zoom-in" data-aos-delay="550">Ajukan Skripsi</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Semua elemen animasi langsung muncul saat load
    document.querySelectorAll('[data-aos]').forEach(el => {
        el.classList.add('aos-init', 'aos-animate');
    });

    // Optional: jalankan AOS sekali untuk properti animasi
    AOS.init({
        duration: 700,
        once: true,
        mirror: false,
        disableMutationObserver: true
    });
});
</script>
<script>
function updateNidn(select) {
    const nidnField = document.getElementById('nidnField');
    const selectedOption = select.options[select.selectedIndex];
    const nidn = selectedOption.getAttribute('data-nidn') || '';
    nidnField.value = nidn;
}
</script>

@endpush
