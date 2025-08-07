@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap">
            <h6 class="mb-0 text-white">
                <i class="fas fa-tags mr-2"></i> Data Perusahaan
            </h6>
            <a href="{{ route('kategori.create') }}" class="btn btn-info btn-sm">
                <i class="fas fa-plus"></i> Tambah Perusahaan
            </a>
        </div>
    </div>

    <div class="card-body">
        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2 fa-lg"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto align-self-center" data-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Notifikasi Error --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2 fa-lg"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto align-self-center" data-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="kategori">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Perusahaan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    table#kategori {
        font-size: 13px;
        width: 100% !important;
        table-layout: auto;
        border-collapse: separate;
        border-spacing: 0;
    }

    table#kategori th,
    table#kategori td {
        padding: 10px 12px !important;
        vertical-align: middle !important;
        white-space: nowrap;
        border: 1px solid #e9ecef;
    }

    table#kategori th {
        background-color: #e9ecef;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    table#kategori tr:hover {
        background-color: #f2f2f2;
    }

    table#kategori td:last-child,
    table#kategori th:last-child {
        text-align: center;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
        padding: 1.25rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    .alert {
        margin-bottom: 1.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem;
    }

    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }

    .btn-sm i {
        margin-right: 4px;
    }
</style>
@endpush

@push('js')
<script>
let presenceTable;

function modalAction(url = '') {
    $('#myModal').load(url, function () {
        $('#myModal').modal('show');
    });
}

$(document).ready(function () {
    presenceTable = $('#kategori').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('kategori/list') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: 'nama', name: 'nama' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: "text-center" }
        ]
    });

    document.addEventListener('shown.lte.pushmenu', function () {
        setTimeout(() => {
            presenceTable.columns.adjust().draw(false);
        }, 300);
    });

    document.addEventListener('collapsed.lte.pushmenu', function () {
        setTimeout(() => {
            presenceTable.columns.adjust().draw(false);
        }, 300);
    });
});
</script>
@endpush
