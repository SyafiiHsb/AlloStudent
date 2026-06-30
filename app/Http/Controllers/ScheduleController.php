<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        // Mengelompokkan jadwal berdasarkan hari
        $schedules = Schedule::where('user_id', Auth::id())->orderBy('start_time')->get()->groupBy('day');
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $categories = Category::where('type', 'schedule')->get();
        return view('schedules.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'start_time' => 'required',
            'end_time' => 'required',
            'subject_name' => 'required|string',
            'room' => 'nullable|string'
        ]);

        Schedule::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'subject_name' => $request->subject_name,
            'room' => $request->room
        ]);

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function exportPDF()
    {
        $schedules = Schedule::where('user_id', Auth::id())->orderBy('day')->orderBy('start_time')->get();
        $pdf = Pdf::loadView('schedules.pdf', compact('schedules'));
        return $pdf->download('laporan_jadwal.pdf');
    }
}