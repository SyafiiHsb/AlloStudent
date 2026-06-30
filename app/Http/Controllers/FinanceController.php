<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{

    public function analysis()
    {
        $user = Auth::user();
        
        // Ambil data transaksi
        $finances = Finance::where('user_id', $user->id)
            ->orderBy('date', 'asc')
            ->with('category')
            ->get();

        // Persiapan Data untuk Grafik Garis (Bulan ke Bulan)
        $monthlyData = array_fill(1, 12, ['income' => 0, 'expense' => 0]);

        foreach ($finances as $f) {
            $month = (int) $f->date->format('n');
            if ($f->transaction_type === 'income') {
                $monthlyData[$month]['income'] += $f->amount;
            } else {
                $monthlyData[$month]['expense'] += $f->amount;
            }
        }

        $incomeChart = array_column($monthlyData, 'income');
        $expenseChart = array_column($monthlyData, 'expense');

        // Persiapan Data untuk Grafik Donat (Kategori Pengeluaran)
        $expenseCategories = $finances
            ->where('transaction_type', 'expense')
            ->groupBy(function ($item) {
                return $item->category->name ?? 'Tanpa Kategori';
            });

        $categoryLabels = [];
        $categoryValues = [];

        foreach ($expenseCategories as $name => $items) {
            $categoryLabels[] = $name;
            $categoryValues[] = $items->sum('amount');
        }

        return view('finances.analysis', compact('incomeChart', 'expenseChart', 'categoryLabels', 'categoryValues'));
    }

    public function index()
    {
        $finances = Finance::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        return view('finances.index', compact('finances'));
    }

    public function create()
    {
        $categories = Category::where('type', 'finance')->get();
        return view('finances.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'transaction_type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        Finance::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'transaction_type' => $request->transaction_type,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description
        ]);

        return redirect()->route('finances.index')->with('success', 'Data keuangan berhasil disimpan!');
    }

    public function destroy($id)
    {
        $finance = Finance::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $finance->delete();
        return redirect()->route('finances.index')->with('success', 'Data berhasil dihapus.');
    }

    // FITUR EXPORT PDF
    public function exportPDF()
    {
        $finances = Finance::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        
        // Hitung total untuk ditampilkan di PDF
        $totalIncome = $finances->where('transaction_type', 'income')->sum('amount');
        $totalExpense = $finances->where('transaction_type', 'expense')->sum('amount');
        
        $pdf = Pdf::loadView('finances.pdf', compact('finances', 'totalIncome', 'totalExpense'));
        return $pdf->download('laporan_keuangan.pdf');
    }
}