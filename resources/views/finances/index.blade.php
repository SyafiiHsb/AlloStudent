@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Riwayat Keuangan</h3>
    <div>
        <a href="{{ route('finances.pdf') }}" class="btn btn-secondary me-2"><i class="fas fa-file-pdf me-1"></i> Download PDF</a>
        <a href="{{ route('finances.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Data</a>
    </div>
</div>

<div class="card card-custom shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($finances as $finance)
                    <tr>
                        <td>{{ $finance->date->format('d M Y') }}</td>
                        <td>{{ $finance->category->name }}</td>
                        <td>{{ $finance->description ?? '-' }}</td>
                        <td>
                            @if($finance->transaction_type == 'income')
                                <span class="badge bg-success">Pemasukan</span>
                            @else
                                <span class="badge bg-danger">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="fw-bold">
                            Rp {{ number_format($finance->amount, 0, ',', '.') }}
                        </td>
                        <td>
                            <form action="{{ route('finances.destroy', $finance->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4">Belum ada data keuangan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection