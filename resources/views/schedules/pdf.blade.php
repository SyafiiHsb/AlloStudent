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
    <h2>Laporan Jadwal - AlloStudent</h2>
    <p>Dicetak pada: {{ date('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Kategori</th>
                <th>Mata Kuliah</th>
                <th>Ruang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr>
                <td>{{ $schedule->day }}</td>
                <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                <td>{{ $schedule->category->name }}</td>
                <td>{{ $schedule->subject_name }}</td>
                <td>{{ $schedule->room }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
