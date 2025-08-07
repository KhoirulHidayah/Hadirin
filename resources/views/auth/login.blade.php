<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Hadirin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    :root {
      --primary: #4A90E2; /* Softer blue */
      --primary-dark: #357ABD; /* Darker shade of primary */
      --accent: #FFD700; /* Golden yellow */
      --text: #333333; /* Darker text for better contrast */
      --bg: linear-gradient(135deg, #e0f2f7 0%, #c1e4f3 100%); /* Lighter, more subtle gradient */
      --glass-bg: rgba(255, 255, 255, 0.7); /* More opaque glass effect */
      --input-bg: rgba(255, 255, 255, 0.95); /* Nearly opaque input background */
      --border-radius-lg: 1.5rem;
      --border-radius-md: 0.75rem;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text);
    }

    .container-login {
      display: flex;
      max-width: 1000px;
      width: 90%; /* Slightly smaller for better padding */
      background: var(--glass-bg);
      backdrop-filter: blur(15px); /* Slightly less blur for clarity */
      border-radius: var(--border-radius-lg);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.4); /* Subtle white border */
    }

    .login-left {
      background: linear-gradient(160deg, var(--primary-dark) 0%, var(--primary) 100%); /* Adjusted gradient direction */
      color: white;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 3rem; /* Increased padding */
      text-shadow: 0 1px 3px rgba(0,0,0,0.1); /* Subtle text shadow */
    }

    .login-left img {
      max-width: 150px; /* Slightly larger logo */
      margin-bottom: 1.5rem;
      filter: drop-shadow(0 5px 10px rgba(0,0,0,0.2)); /* Shadow for the logo */
      animation: float 3s ease-in-out infinite; /* Added float animation */
    }

    .login-left h2 {
      font-size: 2rem; /* Larger heading */
      font-weight: 700;
      margin-bottom: 0.75rem;
    }

    .login-left p {
      font-size: 1rem; /* Slightly larger paragraph */
      line-height: 1.6;
      max-width: 300px; /* Increased max-width */
      opacity: 0.9;
    }

    .login-right {
      flex: 1;
      padding: 3.5rem 3rem; /* Increased padding */
    }

    .login-right h4 {
      font-weight: 700;
      font-size: 1.8rem; /* Larger heading */
      color: var(--primary-dark);
      margin-bottom: 0.5rem;
    }

    .login-right .text-muted {
      font-size: 0.95rem; /* Slightly larger helper text */
      margin-bottom: 2rem; /* More space below helper text */
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

    .btn-toggle-password {
      background: transparent;
      border: none;
      padding-right: 1.2rem; /* More padding */
      color: #999;
      transition: color 0.2s ease;
    }

    .btn-toggle-password:hover {
      color: var(--primary-dark);
    }

    .btn-primary {
      background: linear-gradient(45deg, var(--primary), var(--primary-dark)); /* Diagonal gradient */
      border: none;
      border-radius: var(--border-radius-md);
      padding: 0.9rem; /* Slightly more vertical padding */
      font-weight: 600;
      font-size: 1.05rem; /* Slightly larger font */
      transition: all 0.3s ease;
      width: 100%;
      letter-spacing: 0.5px; /* Slight letter spacing */
    }

    .btn-primary:hover {
      background: linear-gradient(45deg, var(--primary-dark), var(--primary)); /* Reverse gradient on hover */
      box-shadow: 0 8px 20px rgba(74, 144, 226, 0.3); /* More pronounced shadow */
      transform: translateY(-3px); /* More pronounced lift effect */
    }

    .forgot-password-link a {
      font-size: 0.9rem;
      color: var(--primary);
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .forgot-password-link a:hover {
      color: var(--accent);
      text-decoration: underline;
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

    .text-danger {
      font-size: 0.8rem; /* Slightly smaller error message */
      margin-top: 0.4rem; /* Space above error message */
      display: block; /* Ensure it takes full width */
    }

    /* Keyframe for floating animation */
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); } /* Moves up 10px */
      100% { transform: translateY(0px); }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .container-login {
        flex-direction: column;
        width: 95%;
        margin: 1.5rem 0; /* Add some vertical margin */
      }

      .login-left, .login-right {
        width: 100%;
        padding: 2.5rem; /* Adjust padding for smaller screens */
      }

      .login-left {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        border-top-left-radius: var(--border-radius-lg);
        border-top-right-radius: var(--border-radius-lg);
      }

      .login-right {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: var(--border-radius-lg);
        border-bottom-right-radius: var(--border-radius-lg);
      }
    }

    @media (max-width: 576px) {
      .login-right {
        padding: 2rem 1.5rem;
      }

      .login-right h4 {
        font-size: 1.6rem;
      }

      .login-left h2 {
        font-size: 1.8rem;
      }

      .login-left p {
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body>
  <div class="container-login">
    <div class="login-left text-center">
      <img src="{{ asset('images/pln.png') }}" alt="Logo" class="mb-3">
      <h2 class="fw-bold mb-3">Welcome to Hadirin!</h2>
      <p class="fw-light mx-auto">
        Mencatat kehadiran lebih mudah bersama Hadirin.
      </p>
    </div>

    <div class="login-right">
      <h4><i class="fas fa-user-circle me-2"></i>Login Akun</h4>
      <p class="text-muted mb-4">Silakan masukkan detail akun Anda untuk melanjutkan.</p>
      @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif

      <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label for="login" class="form-label">Username atau Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="login" class="form-control" value="{{ old('login') }}" placeholder="Masukkan username atau email Anda" required autofocus>
          </div>
          @error('login') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <div class="input-group align-items-center">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
            <button type="button" class="btn-toggle-password" id="togglePassword" aria-label="Toggle password visibility">
              <i class="fas fa-eye" id="toggleIcon"></i>
            </button>
          </div>
          @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-5">
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