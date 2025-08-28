<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Sistem Skripsi</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('assets/CSS/bootstrap.min.css') }}" />

  <!-- AOS CSS -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

  <!-- Custom Styles -->
  <style>
    body {
      background: url('{{ asset('assets/img/bg.jpg') }}') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      color: #fff;
      margin: 0;
    }

    /* Login Container */
    .login-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 15px;
      background-color: rgba(0, 0, 0, 0.6);
    }

    /* Login Box */
    .login-box {
      background-color: rgba(26, 26, 39, 0.95);
      padding: 30px;
      border-radius: 15px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.6);
      animation: fadeInUp 0.8s ease forwards;
    }

    .login-box img.logo {
      display: block;
      margin: 0 auto 20px;
      max-width: 80px;
      animation: popIn 0.8s ease forwards;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
      color: #f1f1f1;
      animation: fadeInDown 1s ease forwards;
    }

    /* Input Form */
    .form-control {
      background-color: #1e1e2f;
      color: #ffffff;
      border: 1px solid #555;
      transition: all 0.3s ease;
    }

    .form-control::placeholder { color: #aaa; }
    .form-control:focus {
      background-color: #1e1e2f;
      color: #fff;
      border-color: #4e9af1;
      box-shadow: 0 0 8px rgba(78,154,241,0.6);
    }

    /* Button Login */
    .btn-login {
      background-color: #4e9af1;
      border: none;
      width: 100%;
      transition: all 0.3s ease;
    }
    .btn-login:hover {
      background-color: #3b83d6;
      transform: scale(1.02);
      box-shadow: 0 4px 12px rgba(0,123,255,0.5);
    }

    /* Animations */
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
      70% { transform: scale(1.05); }
      100% { opacity: 1; transform: scale(1); }
    }

    /* Footer */
    footer {
      background-color: #15161d;
      color: #888;
      padding: 15px 0;
      text-align: center;
      font-size: 14px;
    }

    /* Responsiveness */
    @media (max-width: 480px) {
      .login-box { padding: 20px; }
      .login-box img.logo { max-width: 60px; margin-bottom: 15px; }
      footer { font-size: 13px; }
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<div class="login-container">
  <div class="login-box">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo" data-aos="zoom-in" data-aos-delay="100" data-aos-duration="800"/>
    <h2 data-aos="fade-down" data-aos-delay="200" data-aos-duration="800">Login</h2>

    <!-- Error -->
    @if ($errors->any())
      <div class="alert alert-danger" data-aos="fade-left" data-aos-delay="300">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('login.submit') }}">
      @csrf
      <div class="mb-3" data-aos="fade-right" data-aos-delay="400">
        <label for="username" class="form-label">Username</label>
        <input id="username" type="text" class="form-control" name="username" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus />
      </div>
      <div class="mb-3" data-aos="fade-right" data-aos-delay="500">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-control" name="password" placeholder="Masukkan password" required />
      </div>
      <button type="submit" class="btn btn-login" data-aos="fade-up" data-aos-delay="600">Login</button>
    </form>
  </div>
</div>

<footer class="mt-auto bg-dark text-center text-white py-3 shadow-sm">
  <small>© {{ date('Y') }} Sistem Pengajuan Skripsi | Universitas Tanri Abeng</small>
</footer>

<script src="{{ asset('assets/JS/bootstrap.bundle.min.js') }}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ 
    duration: 900,
    once: true,
    easing: 'ease-in-out'
  });
</script>
</body>
</html>
