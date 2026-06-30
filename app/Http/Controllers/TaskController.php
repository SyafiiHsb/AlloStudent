<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->orderBy('deadline', 'asc')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $categories = Category::where('type', 'task')->get();
        return view('tasks.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'deadline' => 'required|date',
            'description' => 'nullable|string'
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'deadline' => $request->deadline,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function updateStatus($id)
    {
        $task = Task::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        // Logika Gamifikasi: XP Sistem
        $xpGain = 50; // XP per tugas selesai
        $user = Auth::user();

        if ($task->status == 'pending') {
            $task->status = 'completed';
            
            // Tambah XP
            $user->xp += $xpGain;
            
            // Logika Kenaikan Level Sederhana: Setiap kelipatan 500 XP naik 1 level
            $newLevel = floor($user->xp / 500) + 1;
            $user->level = $newLevel;
            
            $task->save();
            $user->save();

            return redirect()->route('tasks.index')->with('success', "Tugas selesai! Kamu mendapat $xpGain XP!");
        } else {
            // Batalkan selesai (Opsional: kurangi XP atau biarkan saja agar user dihargai)
            $task->status = 'pending';
            $task->save();
            return redirect()->route('tasks.index')->with('success', 'Status tugas diubah menjadi pending.');
        }
    }

    public function exportPDF()
    {
        $tasks = Task::where('user_id', Auth::id())->orderBy('deadline', 'asc')->get();
        $pdf = Pdf::loadView('tasks.pdf', compact('tasks'));
        return $pdf->download('laporan_tugas.pdf');
    }
}