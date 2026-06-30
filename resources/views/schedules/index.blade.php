@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Jadwal Kuliah</h3>
    <div>
        <a href="{{ route('schedules.pdf') }}" class="btn btn-secondary me-2"><i class="fas fa-file-pdf me-1"></i> Download PDF</a>
        <a href="{{ route('schedules.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Jadwal</a>
    </div>
</div>

<div class="row">
    @forelse($schedules as $day => $listSchedule)
    <div class="col-md-6 mb-4">
        <div class="card card-custom shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 fw-bold">{{ $day }}</h5>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($listSchedule as $sched)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-light text-dark border me-2">{{ $sched->start_time }}</span>
                        <span class="badge bg-secondary text-white me-2">{{ $sched->category->name }}</span>
                        <strong>{{ $sched->subject_name }}</strong>
                    </div>
                    <small class="text-muted">{{ $sched->room }}</small>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">Belum ada jadwal kuliah.</p>
    </div>
    @endforelse
</div>
@endsection