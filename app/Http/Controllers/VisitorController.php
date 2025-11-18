<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Exports\VisitorExport;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Visitor::query();

        // Filter tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->where('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->where('tanggal', '<=', $request->tanggal_akhir);
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori != 'semua') {
            $query->where('kategori', $request->kategori);
        }

        $visitors = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10);

        return view('visitors.index', [
            'visitors' => $visitors,
            'filters' => $request->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('visitors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pelanggan,tamu',
            'tujuan_kunjungan' => 'required|string',
            'kontak' => 'required|string|max:255',
        ]);

        Visitor::create($request->all());
        return redirect()->route('visitors.index')->with('success', 'Data tamu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $visitor = Visitor::findOrFail($id);
        return view('visitors.edit', compact('visitor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $visitor = Visitor::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pelanggan,tamu',
            'tujuan_kunjungan' => 'required|string',
            'kontak' => 'required|string|max:255',
        ]);

        $visitor->update($request->all());
        return redirect()->route('visitors.index')->with('success', 'Data tamu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->delete();

        return redirect()->route('visitors.index')->with('success', 'Data tamu berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_akhir = $request->get('tanggal_akhir');
        $kategori = $request->get('kategori');

        return (new VisitorExport($tanggal_mulai, $tanggal_akhir, $kategori))
            ->download('data-tamu-' . date('Y-m-d') . '.xlsx');
    }
}
