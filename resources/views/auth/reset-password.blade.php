<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    :root {
      --primary: #0d6efd;
      --primary-dark: #0b5ed7;
      --accent: #6610f2;
      --text-color: #1f2937;
      --card-bg: #ffffff;
    }

    body {
      background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }

    .reset-card {
      border-radius: 1rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.8s ease-in-out;
      overflow: hidden;
    }

    .card-header {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: white;
      text-align: center;
      padding: 1.5rem;
    }

    .form-control {
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
    }

    .input-group-text {
      border-radius: 0.5rem 0 0 0.5rem;
    }

    .btn-toggle-password {
      border-radius: 0 0.5rem 0.5rem 0;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border: none;
      color: #fff;
      padding: 0.75rem;
      border-radius: 0.5rem;
      font-weight: 600;
      transition: all 0.2s ease-in-out;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-dark), var(--accent));
      color: #fff;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
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
        <div class="card reset-card">
          <div class="card-header">
            <h4><i class="fas fa-unlock-alt me-2"></i>Reset Password</h4>
          </div>
          <div class="card-body p-4 p-md-5">

            <form method="POST" action="{{ route('password.update') }}">
              @csrf
              <input type="hidden" name="token" value="{{ $token }}">

              <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input id="email" type="email" name="email" class="form-control" value="{{ old('email', request()->email) }}" required readonly>
                </div>
                @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  <input id="password" type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                  <button class="btn btn-outline-secondary btn-toggle-password" type="button" id="togglePassword">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                @error('password') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password" required>
                  <button class="btn btn-outline-secondary btn-toggle-password" type="button" id="togglePasswordConfirmation">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>

              <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function setupPasswordToggle(toggleButtonId, passwordInputId) {
      const toggleButton = document.getElementById(toggleButtonId);
      const passwordInput = document.getElementById(passwordInputId);
      const icon = toggleButton.querySelector('i');

      toggleButton.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
      });
    }

    setupPasswordToggle('togglePassword', 'password');
    setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');
  </script>
</body>
</html>
