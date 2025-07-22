<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <style>
    body {
      /* Simple gradient background for a modern look */
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .login-card {
      border: none;
      border-radius: 1rem;
      transition: all 0.3s;
      animation: fadeIn 0.8s ease-in-out;
    }
    .card-header {
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
      padding: 1.5rem;
      background-color: #0d6efd; /* Bootstrap Primary */
    }
    .card-header h4 {
        margin-bottom: 0;
    }
    .form-control {
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
    }
    .input-group-text {
        border-top-left-radius: 0.5rem;
        border-bottom-left-radius: 0.5rem;
    }
    .btn-toggle-password {
        border-top-right-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }
    .btn-primary {
      padding: 0.75rem;
      border-radius: 0.5rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: background-color 0.2s;
    }
    .btn-primary:hover {
      background-color: #0b5ed7; /* Darker shade of primary */
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg login-card">
          <div class="card-header text-center text-white">
            <h4><i class="fas fa-shield-alt me-2"></i>Login Admin</h4>
          </div>
          <div class="card-body p-4 p-md-5">
            
            @if(session('status'))
              <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label for="login" class="form-label">Username atau Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="login" class="form-control" value="{{ old('login') }}" placeholder="Contoh: admin atau admin@gmail.com" required>
                </div>
                @error('login') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
                    <button class="btn btn-outline-secondary btn-toggle-password" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <div class="mb-4 text-end">
                <a href="{{ route('password.request') }}">Lupa Password?</a>
              </div>

              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function () {
      // Toggle tipe input dari password ke text dan sebaliknya
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Ganti ikon mata
      toggleIcon.classList.toggle('fa-eye');
      toggleIcon.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>