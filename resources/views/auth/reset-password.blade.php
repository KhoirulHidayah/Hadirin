<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password</title>

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
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      color: var(--text);
    }

    .reset-card {
      background: var(--glass-bg);
      border: 1px solid rgba(255, 255, 255, 0.4); /* Subtle white border */
      backdrop-filter: blur(15px); /* Slightly less blur for clarity */
      -webkit-backdrop-filter: blur(15px);
      border-radius: var(--border-radius-lg);
      padding: 3rem; /* Increased overall padding */
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
      animation: fadeIn 0.7s ease-in-out;
      width: 100%; /* Ensure card takes full column width */
    }

    .card-header {
      text-align: center;
      margin-bottom: 2rem; /* More space below header */
      padding: 0; /* Remove default padding */
    }

    .card-header h4 {
      font-weight: 700;
      font-size: 2rem; /* Larger heading */
      color: var(--primary-dark);
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
      letter-spacing: 0.5px; /* Slight letter spacing */
    }

    .btn-primary:hover {
      background: linear-gradient(45deg, var(--primary-dark), var(--primary)); /* Reverse gradient on hover */
      box-shadow: 0 8px 20px rgba(74, 144, 226, 0.3); /* More pronounced shadow */
      transform: translateY(-3px); /* More pronounced lift effect */
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
      .reset-card {
        padding: 2rem 1.5rem; /* Adjusted padding for smaller screens */
        border-radius: var(--border-radius-lg); /* Ensure full border-radius on small screens */
      }
      .card-header h4 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="reset-card">
          <div class="card-header">
            <h4><i class="fas fa-lock-open me-2"></i>Reset Password</h4> </div>
          <div class="card-body">

            <form method="POST" action="{{ route('password.update') }}">
              @csrf
              <input type="hidden" name="token" value="{{ $token }}">

              <div class="mb-4"> <label for="email" class="form-label">Alamat Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input id="email" type="email" name="email" class="form-control" value="{{ old('email', request()->email) }}" required readonly>
                </div>
                @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <div class="mb-4"> <label for="password" class="form-label">Password Baru</label>
                <div class="input-group align-items-center">
                  <span class="input-group-text"><i class="fas fa-key"></i></span> <input id="password" type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                  <button class="btn-toggle-password" type="button" id="togglePassword" aria-label="Toggle new password visibility">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                  </button>
                </div>
                @error('password') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <div class="mb-5"> <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group align-items-center">
                  <span class="input-group-text"><i class="fas fa-check-double"></i></span> <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password" required>
                  <button class="btn-toggle-password" type="button" id="togglePasswordConfirmation" aria-label="Toggle confirm password visibility">
                    <i class="fas fa-eye" id="toggleIconConfirmation"></i>
                  </button>
                </div>
                @error('password_confirmation') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
              </div>

              <button type="submit" class="btn btn-primary w-100">Reset Password</button> </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function setupToggle(toggleId, inputId, iconId) {
      const toggle = document.getElementById(toggleId);
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);

      toggle.addEventListener('click', function () {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
      });
    }

    setupToggle('togglePassword', 'password', 'toggleIcon');
    setupToggle('togglePasswordConfirmation', 'password_confirmation', 'toggleIconConfirmation');
  </script>
</body>
</html>