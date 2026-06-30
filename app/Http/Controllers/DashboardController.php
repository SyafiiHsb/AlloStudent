<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Models\Task;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Logika Keuangan
        $totalIncome = Finance::where('user_id', $user->id)->where('transaction_type', 'income')->sum('amount');
        $totalExpense = Finance::where('user_id', $user->id)->where('transaction_type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Logika Tugas
        $pendingTasks = Task::where('user_id', $user->id)->where('status', 'pending')->count();
        $completedTasks = Task::where('user_id', $user->id)->where('status', 'completed')->count();

        // Logika Jadwal (Ambil Jadwal Hari Ini)
        // Note: Carbon sudah digunakan secara implicit oleh Laravel helpers
        $todaySchedule = Schedule::where('user_id', $user->id)
            ->where('day', date('l')) // 'l' format gives full day name (Monday, etc)
            ->orderBy('start_time')
            ->get();

        return view('dashboard', compact('balance', 'totalIncome', 'totalExpense', 'pendingTasks', 'completedTasks', 'todaySchedule'));
    }
}