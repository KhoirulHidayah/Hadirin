<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  
  <style>
    body {
      /* Matching gradient background for consistency */
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .forgot-password-card {
      border: none;
      border-radius: 1rem;
      animation: fadeIn 0.8s ease-in-out;
    }
    .card-header {
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
      padding: 1.5rem;
    }
    .card-header h4 {
      margin-bottom: 0;
      font-weight: 600;
    }
    .form-control {
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
    }
    .input-group-text {
      border-top-left-radius: 0.5rem;
      border-bottom-left-radius: 0.5rem;
    }
    .btn-warning {
      padding: 0.75rem;
      border-radius: 0.5rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.2s;
    }
    .back-to-login {
        text-decoration: none;
        color: #6c757d;
        transition: color 0.2s;
    }
    .back-to-login:hover {
        color: #0d6efd;
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
        <div class="card shadow-lg forgot-password-card">
          <div class="card-header text-center bg-warning text-dark">
            <h4><i class="fas fa-key me-2"></i>Reset Password Anda</h4>
          </div>
          <div class="card-body p-4 p-md-5">

            @if(session('status'))
              <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
              </div>
            @else
              <p class="text-muted text-center mb-4">
                Tidak masalah. Masukkan alamat email yang terdaftar dan kami akan mengirimkan link untuk mereset password Anda.
              </p>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
              @csrf

              <div class="mb-4">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="contoh@email.com" required autofocus>
                </div>
                @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <button type="submit" class="btn btn-warning w-100">Kirim Link Reset Password</button>

              <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="back-to-login">
                  <i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Login
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>