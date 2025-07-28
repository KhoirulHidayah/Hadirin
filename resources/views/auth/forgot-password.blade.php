<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lupa Password</title>

  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>

  <style>
    :root {
      --primary: #007bff;
      --primary-dark: #0056b3;
      --accent: #feda00;
      --text: #1e1e2f;
      --bg: linear-gradient(135deg, #feda0010, #007bff22);
      --card-bg: rgba(255, 255, 255, 0.45);
      --input-bg: rgba(255, 255, 255, 0.9);
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .forgot-password-card {
      background: var(--card-bg);
      border-radius: 1.25rem;
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.7s ease-in-out;
    }

    .card-header {
      text-align: center;
      background: transparent;
      border-bottom: none;
      padding: 2rem 1.5rem 1rem;
    }

    .card-header h4 {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--primary-dark);
    }

    .card-body {
      padding: 1.5rem 2.5rem 2.5rem;
    }

    .form-label {
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 0.5rem;
    }

    .input-group {
      background: var(--input-bg);
      border-radius: 0.75rem;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
      transition: box-shadow 0.3s ease;
    }

    .input-group:focus-within {
      box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
    }

    .form-control {
      background: transparent;
      border: none;
      padding: 0.9rem 1rem;
      font-size: 0.875rem;;
    }

    .input-group-text {
      background: transparent;
      border: none;
      color: #7f8c8d;
    }

    .form-control::placeholder {
      color: #a0a0b2;
    }

    .btn-warning {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border: none;
      border-radius: 0.75rem;
      padding: 0.85rem;
      font-weight: 600;
      font-size: 1rem;
      transition: all 0.2s ease;
      color: #fff; /* Teks putih */
    }

    .btn-warning:hover {
      background: linear-gradient(135deg, var(--primary-dark), var(--accent));
      box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
      transform: translateY(-2px);
      color: #fff; /* Tetap putih saat hover */
    }

    .alert-success {
      background-color: #d1e7dd;
      border: 1px solid #badbcc;
      color: #0f5132;
      font-size: 0.9rem;
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
    }

    .back-to-login {
      display: inline-block;
      margin-top: 1.5rem;
      font-size: 0.9rem;
      color: var(--primary);
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .back-to-login:hover {
      color: var(--accent);
      text-decoration: underline;
    }

    .text-danger {
      font-size: 0.85rem;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 576px) {
      .card-body {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card forgot-password-card">
          <div class="card-header">
            <h4><i class="fas fa-key me-2"></i>Reset Password</h4>
          </div>
          <div class="card-body">

            @if(session('status'))
              <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
              </div>
            @else
              <p class="text-muted text-center mb-4">
                Masukkan alamat email yang terdaftar. Kami akan mengirimkan link untuk reset password Anda.
              </p>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
              @csrf

              <div class="mb-4">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
                </div>
                @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <button type="submit" class="btn btn-warning w-100">Kirim Link Reset Password</button>

              <div class="text-center">
                <a href="{{ route('login') }}" class="back-to-login">
                  <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
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
