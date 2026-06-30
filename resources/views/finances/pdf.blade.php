<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Keuangan - AlloStudent</h2>
    <p>Dicetak pada: {{ date('d M Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($finances as $item)
            <tr>
                <td>{{ $item->date->format('d/m/Y') }}</td>
                <td>{{ $item->transaction_type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->description }}</td>
                <td class="text-right">{{ number_format($item->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="margin-top: 20px;">Ringkasan:</h3>
    <p>Total Pemasukan: Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
    <p>Total Pengeluaran: Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
    <h3>Saldo: Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</h3>
</body>
</html>