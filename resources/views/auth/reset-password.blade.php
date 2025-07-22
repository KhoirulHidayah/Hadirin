<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Password Baru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <style>
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .reset-card {
      border: none;
      border-radius: 1rem;
      animation: fadeIn 0.8s ease-in-out;
    }
    .card-header {
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
      padding: 1.5rem;
      background-color: #198754; /* Bootstrap Success color */
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
    .btn-success {
      padding: 0.75rem;
      border-radius: 0.5rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: background-color 0.2s;
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
        <div class="card shadow-lg reset-card">
          <div class="card-header text-center text-white">
            <h4><i class="fas fa-unlock-alt me-2"></i>Buat Password Baru</h4>
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
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password" required>
                   <button class="btn btn-outline-secondary btn-toggle-password" type="button" id="togglePasswordConfirmation">
                      <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>

              <button type="submit" class="btn btn-success w-100">Reset Password</button>
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

      toggleButton.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
      });
    }

    // Setup for the 'New Password' field
    setupPasswordToggle('togglePassword', 'password');

    // Setup for the 'Confirm Password' field
    setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');
  </script>
</body>
</html>