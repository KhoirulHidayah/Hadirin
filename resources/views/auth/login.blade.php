<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Hadirin</title>

  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

  <style>
    :root {
      --primary: #007bff;
      --primary-dark: #0056b3;
      --accent: #feda00;
      --text: #1e1e2f;
      --bg: linear-gradient(135deg, #feda0015 0%, #007bff20 100%);
      --glass-bg: rgba(255, 255, 255, 0.25);
      --input-bg: rgba(255, 255, 255, 0.85);
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container-login {
      display: flex;
      max-width: 1000px;
      width: 95%;
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      border-radius: 1.5rem;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .login-left {
      background: linear-gradient(135deg, var(--primary-dark), var(--primary));
      color: white;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .login-left img {
      max-width: 100px;
      margin-bottom: 1rem;
    }

    .login-left h2 {
      font-size: 1.8rem;
      font-weight: 700;
    }

    .login-right {
      flex: 1;
      padding: 3rem 2.5rem;
    }

    .login-right h4 {
      font-weight: 700;
      font-size: 1.5rem;
      color: var(--primary-dark);
    }

    .form-label {
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 0.5rem;
    }

    .input-group {
      background: var(--input-bg);
      border-radius: 0.75rem;
      box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
      transition: box-shadow 0.3s ease;
    }

    .input-group:focus-within {
      box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
    }

    .form-control {
      background: transparent;
      border: none;
      padding: 0.9rem 1rem;
      font-size: 0.875rem;
    }

    .form-control:focus {
      background: transparent;
      box-shadow: none;
      color: var(--text);
    }

    .input-group-text {
      background: transparent;
      border: none;
      color: #7f8c8d;
    }

    .btn-toggle-password {
      background: transparent;
      border: none;
      padding-right: 0.75rem;
      color: #7f8c8d;
    }

    .btn-toggle-password:hover {
      color: var(--primary-dark);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border: none;
      border-radius: 0.75rem;
      padding: 0.85rem;
      font-weight: 600;
      font-size: 1rem;
      transition: all 0.2s ease;
      width: 100%;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-dark), var(--accent));
      box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
      transform: translateY(-2px);
    }

    .forgot-password-link a {
      font-size: 0.9rem;
      color: var(--primary);
      text-decoration: none;
    }

    .forgot-password-link a:hover {
      color: var(--accent);
      text-decoration: underline;
    }

    .alert-success {
      background-color: #d1e7dd;
      border: 1px solid #badbcc;
      color: #0f5132;
      font-size: 0.9rem;
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
    }

    .text-danger {
      font-size: 0.85rem;
    }

    @media (max-width: 768px) {
      .container-login {
        flex-direction: column;
      }

      .login-left, .login-right {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="container-login">
    <!-- Kiri: Logo dan Branding -->
    <div class="login-left text-center">
      <img src="{{ asset('images/pln.png') }}" alt="Logo" class="mb-3" style="max-width: 150px;">
      <h2 class="fw-semibold mb-2" style="font-size: 1.5rem;">Welcome to Hadirin!</h2>
      <p class="fw-light mx-auto" style="max-width: 250px; font-size: 0.9rem;">
        Mencatat kehadiran lebih mudah bersama Hadirin
      </p>
    </div>

    <!-- Kanan: Form Login -->
    <div class="login-right">
      <h4><i class="fas fa-user-shield me-2"></i>Login</h4>
      <p class="text-muted mb-4">Login ke akun Anda.</p>

      @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif

      <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="login" class="form-label">Username atau Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="login" class="form-control" value="{{ old('login') }}" placeholder="Masukkan username atau email Anda" required autofocus>
          </div>
          @error('login') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group align-items-center">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
            <button type="button" class="btn-toggle-password" id="togglePassword">
              <i class="fas fa-eye" id="toggleIcon"></i>
            </button>
          </div>
          @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">
              <small>Ingat Saya</small>
            </label>
          </div>
          <div class="forgot-password-link">
            <a href="{{ route('password.request') }}" class="small">Lupa Password?</a>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>

  <!-- Show/Hide Password Script -->
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      toggleIcon.classList.toggle('fa-eye');
      toggleIcon.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>
