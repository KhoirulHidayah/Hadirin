@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row">
        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible d-flex align-items-center fade show" role="alert">
                <i class="fas fa-check-circle fa-lg mr-3"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="close ms-auto" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Notifikasi Error --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible d-flex align-items-start fade show" role="alert">
                <i class="fas fa-exclamation-triangle fa-lg mr-3 mt-1"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="close ms-auto" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Kolom Edit Profil --}}
        <div class="col-md-6">
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-white">
                        <i class="fas fa-user-cog mr-2"></i> Edit Profil
                    </h6>
                </div>

                <div class="card-body">
                    {{-- FORM UPDATE PROFIL --}}
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}" required>
                            <small class="form-text text-muted">Minimal 6 karakter. Maksimal 50 karakter.</small>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                            <small class="form-text text-muted">Harus berupa email yang valid dan unik.</small>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="avatar">Foto Profil:</label><br>
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" width="80" class="mb-2 rounded">
                            @endif
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal ukuran file: 2MB.</small>
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Ganti Password --}}
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-white">
                        <i class="fas fa-key mr-2"></i> Ganti Password
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('profile.updatePassword') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password">Password Lama:</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="current_password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_password')">
                                    <i class="fas fa-eye" id="toggleCurrentPassword"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Masukkan password lama Anda untuk konfirmasi.</small>
                        </div>

                        <div class="mb-3">
                            <label for="password">Password Baru:</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                                    <i class="fas fa-eye" id="togglePassword"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Minimal 8 karakter.</small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">Konfirmasi Password Baru:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation')">
                                    <i class="fas fa-eye" id="togglePasswordConfirmation"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Ketik ulang password baru Anda.</small>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-sync-alt me-1"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(`toggle${capitalizeFirstLetter(inputId)}`);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
</script>
@endpush
