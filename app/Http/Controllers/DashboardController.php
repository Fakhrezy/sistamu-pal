<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total tamu hari ini
        $tamuHariIni = Visitor::whereDate('tanggal', today())->count();

        // Total tamu bulan ini
        $tamuBulanIni = Visitor::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Total tamu tahun ini
        $tamuTahunIni = Visitor::whereYear('tanggal', now()->year)->count();

        // Total semua tamu
        $totalTamu = Visitor::count();

        // Statistik berdasarkan kategori
        $statistikKategori = Visitor::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();

        return view('dashboard', compact(
            'tamuHariIni',
            'tamuBulanIni',
            'tamuTahunIni',
            'totalTamu',
            'statistikKategori'
        ));
    }
}
