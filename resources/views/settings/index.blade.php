@extends('layouts.app')

@section('content')
<h3 class="mb-4">Pengaturan Akun</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <!-- Profil Settings -->
    <div class="col-md-6 mb-4">
        <div class="card card-custom shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-user me-2"></i>Edit Profil</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.profile') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Settings -->
    <div class="col-md-6 mb-4">
        <div class="card card-custom shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-lock me-2"></i>Ganti Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.password') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Appearance Settings (Tema) -->
    <div class="col-md-12">
        <div class="card card-custom shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-palette me-2"></i>Tampilan Aplikasi</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.theme') }}">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p class="mb-0">Pilih tema yang nyaman untuk mata Anda saat mengelola tugas di malam hari.</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="form-check form-switch d-inline-block">
                                <input type="hidden" name="theme" value="light">
                                <input class="form-check-input" type="checkbox" id="themeSwitch" name="theme" value="dark" {{ auth()->user()->theme === 'dark' ? 'checked' : '' }}>
                                <label class="form-check-label" for="themeSwitch">Dark Mode</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-outline-dark">Terapkan Tema</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Category Management -->
    <div class="col-md-12">
        <div class="card card-custom shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-tags me-2"></i>Kelola Kategori</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Tipe</label>
                            <select name="type" class="form-select" required>
                                <option value="finance">Keuangan</option>
                                <option value="task">Tugas</option>
                                <option value="schedule">Jadwal</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" required placeholder="Contoh: Transport, Ulangan, Lab">
                        </div>
                        <div class="col-md-3 text-end">
                            <button type="submit" class="btn btn-primary w-100">Tambah Kategori</button>
                        </div>
                    </div>
                </form>

                <hr class="my-4">

                @php
                    $categoryTypes = ['finance' => 'Keuangan', 'task' => 'Tugas', 'schedule' => 'Jadwal'];
                @endphp

                @foreach($categoryTypes as $type => $label)
                    <div class="mb-4">
                        <h6 class="mb-3">Kategori {{ $label }}</h6>
                        @if(isset($categories[$type]) && $categories[$type]->count())
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <tbody>
                                        @foreach($categories[$type] as $category)
                                        <tr>
                                            <td class="w-50">
                                                <form method="POST" action="{{ route('categories.update', $category) }}" class="d-flex gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
                                                    <button type="submit" class="btn btn-sm btn-outline-success">Ubah</button>
                                                </form>
                                            </td>
                                            <td class="text-end">
                                                <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Belum ada kategori {{ strtolower($label) }}.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection