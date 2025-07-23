<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Hadirin</title>

  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <!-- Font -->
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
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      color: var(--text);
    }

    .login-card {
      background: var(--glass-bg);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-radius: 1.5rem;
      padding: 2rem 2.5rem;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.7s ease-in-out;
    }

    .card-header {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .card-header h4 {
      font-weight: 700;
      font-size: 2rem;
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
      font-size: 1rem;
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

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="login-card">
          <div class="card-header">
            <h4><i class="fas fa-user-shield me-2"></i>Login Hadirin</h4>
          </div>
          <div class="card-body">
            @if(session('status'))
              <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="login" class="form-label">Username atau Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="login" class="form-control" value="{{ old('login') }}" placeholder="Masukkan username atau email Anda" required>
                </div>
                @error('login') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
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
                @error('password') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <div class="mb-4 text-end forgot-password-link">
                <a href="{{ route('password.request') }}">Lupa Password?</a>
              </div>

              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Password Toggle Script -->
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
