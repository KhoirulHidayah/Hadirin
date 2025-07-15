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
        }

        .sidebar {
            background: linear-gradient(to bottom, #00a0e3, #007acc); /* Gradasi biru PLN */
            width: 250px;
            height: 100vh;
            overflow-y: auto;
            flex-shrink: 0;
            border-right: 5px solid #feda00; /* Aksen kuning PLN */
        }

        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            font-size: 13px;
            padding: 6px 12px;
        }

        .nav-link.active {
            background-color: #feda00 !important;
            color: #003366 !important;
            font-weight: bold;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff !important;
        }

        .nav-icon {
            font-size: 13px !important;
        }

        .nav-header {
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 12px;
        }

        .nav-item {
            font-size: 13px;
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
                <a href="{{ url('/pegawai') }}" class="nav-link {{ ($activeMenu == 'pegawai') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-tie"></i>
                    <p>Pegawai</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/presence') }}" class="nav-link {{ ($activeMenu == 'presence') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-check"></i>
                    <p>Daftar Kegiatan</p>
                </a>
            </li>

            <li class="nav-header">Rekap</li>

            <li class="nav-item">
                <a href="{{ url('/rekap') }}" class="nav-link {{ ($activeMenu == 'rekap') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Rekap Kegiatan</p>
                </a>
            </li>
        </ul>
    </nav>
</div>

</body>
</html>
