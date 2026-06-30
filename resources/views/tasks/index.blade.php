@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Daftar Tugas</h3>
    <div>
        <a href="{{ route('tasks.pdf') }}" class="btn btn-secondary me-2"><i class="fas fa-file-pdf me-1"></i> Download PDF</a>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tugas Baru</a>
    </div>
</div>

<div class="row">
    @forelse($tasks as $task)
    <div class="col-md-4 mb-4">
        <div class="card card-custom shadow-sm h-100 {{ $task->status == 'completed' ? 'bg-light' : '' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-info text-dark">{{ $task->category->name }}</span>
                    @if($task->status == 'completed')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </div>
                <h5 class="card-title fw-bold">{{ $task->title }}</h5>
                <p class="card-text text-muted small"><i class="far fa-clock me-1"></i>Deadline: {{ $task->deadline->format('d M Y') }}</p>
                <p class="card-text">{{ Str::limit($task->description, 80) }}</p>
            </div>
            <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                <form action="{{ route('tasks.update.status', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm {{ $task->status == 'completed' ? 'btn-outline-secondary' : 'btn-primary' }}">
                        {{ $task->status == 'completed' ? 'Tandai Belum' : 'Tandai Selesai' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">Tidak ada tugas saat ini.</p>
    </div>
    @endforelse
</div>
@endsection