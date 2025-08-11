@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap">
            <h6 class="mb-0 text-white">
                <i class="fas fa-building mr-2"></i> Data Unit
            </h6>
            <a href="{{ route('asal_instansi.create') }}" class="btn btn-info btn-sm">
                <i class="fas fa-plus"></i> Tambah Unit
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

        {{-- Filter Kategori dengan tombol Reset --}}
        <div class="mb-3">
            <div class="d-flex align-items-center">
                <label for="kategori_filter" class="form-label mb-0 me-2">Filter berdasarkan Kategori:</label>
                <select class="form-control form-control-sm me-2" id="kategori_filter" style="max-width: 200px;">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategori as $item)
                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-sm btn-secondary" id="reset-filter">
                    <i class="fas fa-sync-alt"></i> Reset
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="asal_instansi">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Unit</th>
                        <th>Perusahaan</th>
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
    table#asal_instansi {
        font-size: 13px;
        width: 100% !important;
        table-layout: auto;
        border-collapse: separate;
        border-spacing: 0;
    }

    table#asal_instansi th,
    table#asal_instansi td {
        padding: 10px 12px !important;
        vertical-align: middle !important;
        white-space: nowrap;
        border: 1px solid #e9ecef;
    }

    table#asal_instansi th {
        background-color: #e9ecef;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    table#asal_instansi tr:hover {
        background-color: #f2f2f2;
    }

    table#asal_instansi td:last-child,
    table#asal_instansi th:last-child {
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
let asalInstansiTable;

$(document).ready(function () {
    asalInstansiTable = $('#asal_instansi').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('asal_instansi/list') }}",
            type: "POST",
            data: function (d) {
                d._token = '{{ csrf_token() }}';
                d.kategori_nama = $('#kategori_filter').val();
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: 'asal_instansi', name: 'asal_instansi' },
            { data: 'kategori_nama', name: 'kategori_nama' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: "text-center" }
        ]
    });

    // Menambahkan event listener untuk filter kategori
    $('#kategori_filter').on('change', function() {
        asalInstansiTable.ajax.reload();
    });

    // Event listener untuk tombol reset
    $('#reset-filter').on('click', function() {
        $('#kategori_filter').val('');
        asalInstansiTable.ajax.reload();
    });

    document.addEventListener('shown.lte.pushmenu', function () {
        setTimeout(() => {
            asalInstansiTable.columns.adjust().draw(false);
        }, 300);
    });

    document.addEventListener('collapsed.lte.pushmenu', function () {
        setTimeout(() => {
            asalInstansiTable.columns.adjust().draw(false);
        }, 300);
    });
});
</script>
@endpush