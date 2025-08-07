<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lupa Password</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>

  <style>
    :root {
      --primary: #4A90E2; /* Softer blue */
      --primary-dark: #357ABD; /* Darker shade of primary */
      --accent: #FFD700; /* Golden yellow */
      --text: #333333; /* Darker text for better contrast */
      --bg: linear-gradient(135deg, #e0f2f7 0%, #c1e4f3 100%); /* Lighter, more subtle gradient */
      --card-bg: rgba(255, 255, 255, 0.7); /* More opaque glass effect */
      --input-bg: rgba(255, 255, 255, 0.95); /* Nearly opaque input background */
      --border-radius-lg: 1.25rem;
      --border-radius-md: 0.75rem;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text);
    }

    .forgot-password-card {
      background: var(--card-bg);
      border-radius: var(--border-radius-lg);
      border: 1px solid rgba(255, 255, 255, 0.4); /* Subtle white border */
      backdrop-filter: blur(15px); /* Slightly less blur for clarity */
      -webkit-backdrop-filter: blur(15px);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
      animation: fadeIn 0.7s ease-in-out;
      width: 100%; /* Ensure card takes full column width */
    }

    .card-header {
      text-align: center;
      background: transparent;
      border-bottom: none;
      padding: 2.5rem 1.5rem 1rem; /* Increased top padding */
    }

    .card-header h4 {
      font-size: 2rem; /* Larger heading */
      font-weight: 700;
      color: var(--primary-dark);
      margin-bottom: 0.5rem;
    }

    .card-body {
      padding: 1.5rem 3rem 3rem; /* Increased padding for spaciousness */
    }

    .card-body .text-muted {
      font-size: 0.95rem; /* Slightly larger helper text */
      margin-bottom: 2rem; /* More space below helper text */
      line-height: 1.6;
    }

    .form-label {
      font-weight: 600;
      font-size: 0.9rem;
      margin-bottom: 0.6rem; /* More space below label */
      color: var(--text);
    }

    .input-group {
      background: var(--input-bg);
      border-radius: var(--border-radius-md);
      box-shadow: 0 2px 8px rgba(0,0,0,0.05); /* Softer shadow for input group */
      transition: all 0.3s ease;
      border: 1px solid rgba(0, 0, 0, 0.1); /* Subtle border for input group */
    }

    .input-group:focus-within {
      box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.25), 0 2px 10px rgba(0,0,0,0.1); /* Brighter, more distinct focus shadow */
      border-color: var(--primary);
    }

    .form-control {
      background: transparent;
      border: none;
      padding: 1rem 1.2rem; /* More padding for a taller input */
      font-size: 0.9rem;
      color: var(--text);
    }

    .form-control::placeholder {
      color: #999;
      opacity: 0.8;
    }

    .form-control:focus {
      background: transparent;
      box-shadow: none;
      color: var(--text);
    }

    .input-group-text {
      background: transparent;
      border: none;
      color: #999; /* Softer icon color */
      padding: 0 1.2rem;
    }

    .btn-submit { /* Renamed from btn-warning for semantic clarity */
      background: linear-gradient(45deg, var(--primary), var(--primary-dark)); /* Diagonal gradient */
      border: none;
      border-radius: var(--border-radius-md);
      padding: 0.9rem; /* Slightly more vertical padding */
      font-weight: 600;
      font-size: 1.05rem; /* Slightly larger font */
      transition: all 0.3s ease;
      color: #fff; /* White text */
      letter-spacing: 0.5px; /* Slight letter spacing */
    }

    .btn-submit:hover {
      background: linear-gradient(45deg, var(--primary-dark), var(--primary)); /* Reverse gradient on hover */
      box-shadow: 0 8px 20px rgba(74, 144, 226, 0.3); /* More pronounced shadow */
      transform: translateY(-3px); /* More pronounced lift effect */
      color: #fff; /* Keep text white on hover */
    }

    .alert-success {
      background-color: #d4edda; /* Lighter green */
      border: 1px solid #c3e6cb;
      color: #155724; /* Darker green text */
      font-size: 0.9rem;
      border-radius: var(--border-radius-md);
      padding: 0.85rem 1.2rem;
      margin-bottom: 1.5rem; /* More space below alert */
    }

    .back-to-login {
      display: inline-block;
      margin-top: 2rem; /* Increased top margin */
      font-size: 0.95rem; /* Slightly larger font */
      color: var(--primary);
      text-decoration: none;
      transition: color 0.2s ease;
      font-weight: 500;
    }

    .back-to-login:hover {
      color: var(--accent);
      text-decoration: underline;
    }

    .text-danger {
      font-size: 0.8rem; /* Slightly smaller error message */
      margin-top: 0.4rem; /* Space above error message */
      display: block; /* Ensure it takes full width */
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 576px) {
      .card-body {
        padding: 1.5rem 1.5rem 2rem; /* Adjusted padding for smaller screens */
      }
      .card-header h4 {
        font-size: 1.8rem;
      }
      .card-body .text-muted {
        font-size: 0.9rem;
      }
      .btn-submit {
        font-size: 1rem;
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
            <h4><i class="fas fa-lock me-2"></i>Lupa Password?</h4> </div>
          <div class="card-body">

            @if(session('status'))
              <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
              </div>
            @else
              <p class="text-muted text-center">
                Jangan khawatir! Masukkan alamat email yang terdaftar. Kami akan mengirimkan link untuk reset password Anda.
              </p>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
              @csrf

              <div class="mb-4">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="contoh@domain.com" required autofocus> </div>
                @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <button type="submit" class="btn btn-submit w-100">Kirim Link Reset Password</button> <div class="text-center">
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