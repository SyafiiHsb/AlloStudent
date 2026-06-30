@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Mahasiswa</h2>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <!-- Keuangan Card -->
        <div class="col-md-4">
            <div class="card card-custom bg-white border-start border-5 border-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Saldo Saat Ini</h6>
                        <h3 class="fw-bold text-primary">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
                        <small class="text-success"><i class="fas fa-arrow-up"></i> Pemasukan: Rp {{ number_format($totalIncome, 0, ',', '.') }}</small><br>
                        <small class="text-danger"><i class="fas fa-arrow-down"></i> Pengeluaran: Rp {{ number_format($totalExpense, 0, ',', '.') }}</small>
                    </div>
                    <div class="card-icon text-primary">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tugas Card -->
        <div class="col-md-4">
            <div class="card card-custom bg-white border-start border-5 border-warning">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Tugas Pending</h6>
                        <h3 class="fw-bold text-warning">{{ $pendingTasks }}</h3>
                        <small class="text-muted">Dari total tugas aktif</small>
                    </div>
                    <div class="card-icon text-warning">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produktivitas Card -->
        <div class="col-md-4">
            <div class="card card-custom bg-white border-start border-5 border-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Tugas Selesai</h6>
                        <h3 class="fw-bold text-success">{{ $completedTasks }}</h3>
                        <small class="text-muted">Luar biasa! Pertahankan.</small>
                    </div>
                    <div class="card-icon text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Jadwal Hari Ini -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-calendar-day me-2"></i>Jadwal Hari Ini ({{ date('l') }})</h5>
                </div>
                <div class="card-body">
                    @if($todaySchedule->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($todaySchedule as $schedule)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-primary mb-1">{{ $schedule->start_time }} - {{ $schedule->end_time }}</span>
                                    <h6 class="mb-0 fw-bold">{{ $schedule->subject_name }}</h6>
                                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $schedule->room ?? 'Online' }}</small>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-muted my-4">Tidak ada jadwal kuliah hari ini. Waktu belajar mandiri!</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card card-custom shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary fw-bold">Akses Cepat</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="d-grid gap-3">
                        <a href="{{ route('finances.create') }}" class="btn btn-outline-primary btn-lg text-start">
                            <i class="fas fa-plus-circle me-3"></i> Catat Keuangan
                        </a>
                        <a href="{{ route('tasks.create') }}" class="btn btn-outline-warning btn-lg text-start">
                            <i class="fas fa-tasks me-3"></i> Tambah Tugas Baru
                        </a>
                        <a href="{{ route('schedules.create') }}" class="btn btn-outline-info btn-lg text-start">
                            <i class="fas fa-calendar-plus me-3"></i> Atur Jadwal Kuliah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection