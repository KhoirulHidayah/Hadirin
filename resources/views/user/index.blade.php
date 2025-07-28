@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap">
            <h6 class="mb-0 text-white">
                <i class="fas fa-user-tie mr-2"></i> Data User
            </h6>
            <a class="btn btn-info btn-sm" href="{{ route('user.create') }}">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>
    </div>
    <div class="card-body">
        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2 fa-lg"></i>
                <div>{{ session('success') }}</div>
                <button type="button"
                        class="btn-close ms-auto align-self-center"
                        data-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif
        {{-- Notifikasi Eror --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2 fa-lg"></i>
                <div>{{ session('error') }}</div>
                <button type="button"
                        class="btn-close ms-auto align-self-center"
                        data-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="user">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Email</th>
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
    body {
        background-color: #f8f9fa;
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

    table#user {
        font-size: 13px;
        width: 100% !important;
        table-layout: auto;
        border-collapse: separate;
        border-spacing: 0;
    }

    table#user th,
    table#user td {
        padding: 10px 12px !important;
        vertical-align: middle !important;
        white-space: nowrap;
        border: 1px solid #e9ecef;
    }

    table#user th {
        background-color: #e9ecef;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    table#user tr:hover {
        background-color: #f2f2f2;
    }

    table#user td:nth-child(4),
    table#user th:nth-child(4) {
        width: 120px !important;
        text-align: center;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 13px;
        padding: 1rem 0;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.3em 0.6em;
    }

    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }

    .alert {
        margin-bottom: 1.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem;
    }
</style>
@endpush

@push('js')
<script>
let userTable;

$(document).ready(function () {
    userTable = $('#user').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('user.index') }}",
            type: "GET"
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "username", name: "username" },
            { data: "email", name: "email" },
            { data: "action", name: "action", orderable: false, searchable: false, className: "text-center" }
        ]
    });

    document.addEventListener('shown.lte.pushmenu', function () {
        setTimeout(() => {
            userTable.columns.adjust().draw(false);
        }, 300);
    });

    document.addEventListener('collapsed.lte.pushmenu', function () {
        setTimeout(() => {
            userTable.columns.adjust().draw(false);
        }, 300);
    });
});
</script>
@endpush
