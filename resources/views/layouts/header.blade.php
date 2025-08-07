<style>
  /* Navbar utama dengan warna putih */
  .navbar {
      background-color: #ffffff;
      border-bottom: 1px solid #ffffff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  /* Tombol pushmenu (☰) warna kuning */
  .navbar .nav-link[data-widget="pushmenu"] {
      color: #FFEB00 !important;
      font-size: 1.2rem;
      font-weight: bold;
  }

  .navbar .nav-link[data-widget="pushmenu"]:hover {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 5px;
  }

  /* Navbar kanan (Admin) tanpa kotak */
  .navbar .nav-link.dropdown-toggle {
      color: #007acc !important;
      padding: 6px 12px;
      font-weight: 500;
      /* Dihilangkan:
      background-color: #ffffff;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      border-radius: 5px;
      */
  }

  .navbar .nav-link.dropdown-toggle:hover {
      background-color: transparent;
  }

  /* Dropdown menu */
  .dropdown-menu {
      background: #f9f9f9;
      border: 1px solid #ccc;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  }

  .dropdown-item:hover {
      background-color: #007BFF;
      color: #FFEB00;
  }

  .dropdown-item i {
      color: #007BFF;
      margin-right: 5px;
  }

  .dropdown-item:hover i {
      color: #FFEB00;
  }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand">
  <!-- Sidebar Toggle -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

<!-- Navbar Right -->
<ul class="navbar-nav ml-auto">
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      
      {{-- Tampilkan Avatar --}}
      @if (Auth::user()->avatar)
        <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
            alt="Avatar"
            class="rounded-circle"
            width="32" height="32"
            style="object-fit: cover; margin-right: 8px;">
      @else
        <i class="fas fa-user-circle fa-2x mr-2"></i>
      @endif

      {{-- Tampilkan Username --}}
      <span>{{ Auth::user()->username ?? 'Guest' }}</span>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
      <!-- Link ke edit profil -->
      <a class="dropdown-item" href="{{ route('profile.edit') }}">
        <i class="fas fa-user"></i> Manage Profile
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </div>
  </li>
</ul>

</nav>
