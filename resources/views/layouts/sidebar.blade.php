<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar Gradasi PLN</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
      min-height: 100vh;
      flex-direction: column;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      background: linear-gradient(to bottom, #007bff, #0056b3);
      width: 250px;
      height: 100vh;
      overflow-y: auto;
      flex-shrink: 0;
      border-right: 5px solid #FFEB00;
    }

    .nav-link {
      color: #ffffff !important;
      font-weight: 500;
      font-size: 14px;
      padding: 10px 16px;
      display: flex;
      align-items: center;
      transition: background 0.2s ease;
    }

    .nav-link p {
      margin: 0;
      margin-left: 10px;
      line-height: 1.2;
    }

    .nav-link.active {
      background-color: #FFEB00 !important;
      color: #003366 !important;
      font-weight: bold;
    }

    .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.15);
      color: #ffffff !important;
    }

    .nav-icon {
      font-size: 16px;
      width: 20px;
      text-align: center;
    }

    .nav-header {
      color: #ffffff;
      padding: 10px 16px 5px 16px;
      font-weight: bold;
      font-size: 13px;
      text-transform: uppercase;
      opacity: 0.85;
    }

    .nav-item {
      font-size: 14px;
    }

    .sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 3px;
    }
  </style>
</head>
<body class="sidebar-mini sidebar-collapse">

  <!-- Sidebar -->
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header">Master Data</li>

        <li class="nav-item">
            <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori') ? 'active' : '' }}">
                <i class="nav-icon fas fa-building"></i> 
                <p>Data Perusahaan</p>
            </a>
        </li>    

        <li class="nav-item">
          <a href="{{ url('/pegawai') }}" class="nav-link {{ ($activeMenu == 'pegawai') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>Data Pegawai</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ url('/presence') }}" class="nav-link {{ ($activeMenu == 'presence') ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar-check"></i>
            <p>Daftar Kegiatan</p>
          </a>
        </li>

        <li class="nav-header">Formulir</li>

        <li class="nav-item">
          <a href="{{ url('/logo_formulir') }}" class="nav-link {{ ($activeMenu == 'logo_formulir') ? 'active' : '' }}">
            <i class="nav-icon fas fa-image"></i>
            <p>Title dan Logo Header</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ url('/slide') }}" class="nav-link {{ ($activeMenu == 'slide') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Data Slide Show</p>
          </a>
        </li>
        
        <li class="nav-header">User</li>

        <li class="nav-item">
          <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i> {{-- bisa diganti sesuai kebutuhan --}}
            <p>Data User</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>

</body>
</html>
