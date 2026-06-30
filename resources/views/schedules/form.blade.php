@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom shadow-sm">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 text-primary">Tambah Jadwal Kuliah</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('schedules.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <select name="day" class="form-select" required>
                            <option value="Monday">Senin</option>
                            <option value="Tuesday">Selasa</option>
                            <option value="Wednesday">Rabu</option>
                            <option value="Thursday">Kamis</option>
                            <option value="Friday">Jumat</option>
                            <option value="Saturday">Sabtu</option>
                            <option value="Sunday">Minggu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jam Selesai</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Kuliah</label>
                        <input type="text" name="subject_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ruang / Lokasi</label>
                        <input type="text" name="room" class="form-control">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection