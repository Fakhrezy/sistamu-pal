<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Exports\VisitorExport;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display public form for visitors
     */
    public function publicForm()
    {
        return view('visitors.public-form');
    }

    /**
     * Store visitor data from public form
     */
    public function publicStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pelanggan,tamu',
            'tujuan_kunjungan' => 'required|string',
            'kontak' => 'required|string|max:255',
        ]);

        Visitor::create([
            'tanggal' => now()->format('Y-m-d'),
            'jam' => now()->format('H:i:s'),
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'kontak' => $request->kontak,
        ]);

        return redirect()->route('visitor.form')->with('success', 'Terima kasih! Data Anda telah berhasil disimpan.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Visitor::query();

        // Filter pencarian nama
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

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
            'jam_checkout' => 'nullable',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pelanggan,tamu',
            'tujuan_kunjungan' => 'required|string',
            'kontak' => 'required|string|max:255',
            'status' => 'required|in:check in,check out',
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
            'jam_checkout' => 'nullable',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pelanggan,tamu',
            'tujuan_kunjungan' => 'required|string',
            'kontak' => 'required|string|max:255',
            'status' => 'required|in:check in,check out',
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

    public function toggleStatus(string $id)
    {
        $visitor = Visitor::findOrFail($id);

        // Toggle status
        $newStatus = $visitor->status === 'check in' ? 'check out' : 'check in';

        $updateData = ['status' => $newStatus];
        if ($newStatus === 'check out') {
            $updateData['jam_checkout'] = now()->format('H:i:s');
        } else {
            $updateData['jam_checkout'] = null;
        }

        $visitor->update($updateData);

        return redirect()->route('visitors.index')->with('success', 'Status berhasil diubah menjadi ' . $newStatus . '.');
    }

    public function export(Request $request)
    {
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_akhir = $request->get('tanggal_akhir');
        $kategori = $request->get('kategori');
        $search = $request->get('search');

        $exporter = new VisitorExport($tanggal_mulai, $tanggal_akhir, $kategori, $search);
        $data = $exporter->export();

        $filename = 'data-tamu-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
