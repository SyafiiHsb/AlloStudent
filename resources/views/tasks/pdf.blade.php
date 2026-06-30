<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Tugas - AlloStudent</h2>
    <p>Dicetak pada: {{ date('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->category->name }}</td>
                <td>{{ $task->deadline->format('d/m/Y') }}</td>
                <td>{{ $task->status == 'completed' ? 'Selesai' : 'Pending' }}</td>
                <td>{{ $task->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
