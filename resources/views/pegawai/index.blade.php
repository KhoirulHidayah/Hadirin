@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-body">
        <div class="card-tools mb-3 text-right"> 
            <div class="card-body" style="text-align: right;">
                    <!-- Tombol Tambah Pegawai -->
                    <a class="btn btn-primary" href="{{ url('pegawai/create') }}">
                        <i class="fas fa-plus"></i> Tambah Pegawai
                    </a>
            </div> 
        </div>
        <!-- Tabel -->
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="pegawai">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pegawai</th>
                        <th>NIP</th>
                        <th>Jabatan/Bidang</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Unit/Asal Instansi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>

@endsection
@push('js')
<script>
function modalAction(url = '') {
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
}

$(document).ready(function() {
    $('#pegawai').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('pegawai/list') }}",
            type: "POST",
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: 'nama', name: 'nama' },
            { data: 'nip', name: 'nip' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' }, 
            { data: 'asal_instansi', name: 'asal_instansi' },   
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: "text-center" }
        ]
    });
});
</script>
@endpush
