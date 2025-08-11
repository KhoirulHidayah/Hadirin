@extends('layouts.template')

@section('content')
<div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white">
            <i class="fas fa-user-edit mr-2"></i> Edit User
        </h6>
    </div>
    <div class="card-body">
        @empty($user)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="icon fas fa-ban mr-2"></i> Kesalahan!</h5>
                Data user tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <a href="{{ route('user.index') }}" class="btn btn-sm btn-secondary mt-3">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        @else
            <form method="POST" action="{{ route('user.update', $user->id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row mb-3">
                    <label for="username" class="col-sm-2 col-form-label text-md-right">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                        @error('username')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="email" class="col-sm-2 col-form-label text-md-right">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="password" class="col-sm-2 col-form-label text-md-right">Password</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-sm">
                            <input type="password" class="form-control password-input" name="password" placeholder="Kosongkan jika tidak diubah | Minimal 8 karakter">
                            <button class="btn btn-outline-secondary toggle-password-btn" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-sm mr-2">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                        <a href="{{ route('user.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        @endempty
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-password-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = btn.parentElement.querySelector('.password-input');
                const icon = btn.querySelector('i');
                const isPassword = input.type === 'password';

                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
            });
        });
    });
</script>
@endpush


