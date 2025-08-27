@extends('layouts.app')

@section('title', 'Edit Pengajuan Mahasiswa')

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

.input-group-text i,
.input-group-text i::before,
.input-group-text svg {
    color: #f1f1f1 !important;
    fill: #f1f1f1 !important;
}

.form-control, .form-select {
    background-color: #1f1f2f;
    color: #fff;
    border: 1px solid #555;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
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

.btn-secondary {
    border-radius: 10px;
    background-color: #6c757d;
    border: none;
    width: 100%;
    padding: 12px 20px;
    font-size: 1rem;
    font-weight: 600;
    transition: transform 0.2s, box-shadow 0.2s;
    color: #fff;
}

.btn-secondary:hover {
    transform: translateY(-2px) scale(1.01);
    box-shadow: 0 6px 18px rgba(0,0,0,0.3);
}

.form-control::placeholder { color: #ddd !important; opacity: 1 !important; }

.status-text {
    font-weight: 600;
}

.status-menunggu { color: #FFC107; }
.status-diterima { color: #28a745; }
.status-ditolak { color: #dc3545; }

.file-upload-wrapper {
    position: relative;
}

.file-upload-wrapper input[type=file] {
    opacity: 0;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.btn-upload {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    padding: 10px 15px;
    background: linear-gradient(90deg,#4e9af1,#6aa8f9);
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s, background 0.3s;
}

.btn-upload:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 6px 18px rgba(78,154,241,0.4);
    background: linear-gradient(90deg,#6aa8f9,#4e9af1);
}

</style>
@endpush

@section('content')
<div class="container" data-aos="fade-up">
    <h2 data-aos="fade-down" data-aos-duration="800">Edit Pengajuan</h2>

    @if ($errors->any())
        <div class="alert alert-danger" data-aos="fade-down">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glass-card" data-aos="fade-up" data-aos-delay="100">
        <form action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="150">
                <label class="form-label">Judul Skripsi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                    <input type="text" name="judul" class="form-control" placeholder="Masukkan judul" value="{{ old('judul', $pengajuan->judul) }}" required>
                </div>
            </div>

            <!-- File Upload -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="200">
                <label class="form-label">File (opsional jika ingin ganti)</label>
                @if($pengajuan->file)
                    <p>File saat ini: <a href="{{ asset('storage/pengajuan/' . $pengajuan->file) }}" target="_blank">{{ $pengajuan->file }}</a></p>
                @endif
                <div class="input-group">
                    <input type="file" name="file" class="form-control">
                    <button class="btn btn-upload" type="button"><i class="bi bi-upload"></i> Upload</button>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="250">
                <label class="form-label">Deskripsi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi">{{ old('deskripsi', $pengajuan->deskripsi) }}</textarea>
                </div>
            </div>

            <!-- Komentar Dosen -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="300">
                <label class="form-label">Komentar Dosen</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-chat-left-text"></i></span>
                    <textarea name="komentar" class="form-control" rows="3" placeholder="Masukkan komentar dosen">{{ old('komentar', $pengajuan->komentar) }}</textarea>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-3" data-aos="fade-up" data-aos-delay="350">
                <label class="form-label">Status Pengajuan</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-flag"></i></span>
                    <select name="status" class="form-select" required>
                        <option value="menunggu" {{ $pengajuan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ $pengajuan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-2" data-aos="zoom-in" data-aos-delay="400">
                <i class="bi bi-check-circle"></i> Update Pengajuan
            </button>
            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary mt-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    AOS.init({
        duration: 700,
        once: true
    });
});
</script>
@endpush
