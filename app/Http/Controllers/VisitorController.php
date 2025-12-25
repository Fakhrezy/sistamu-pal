<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Exports\VisitorExport;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            'asal_instansi' => 'nullable|string|max:255',
        ]);

        Visitor::create([
            'tanggal' => now()->format('Y-m-d'),
            'jam' => now()->format('H:i:s'),
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'kontak' => $request->kontak,
            'asal_instansi' => $request->asal_instansi,
        ]);

        return redirect()->route('visitor.form')->with('success', 'Terima kasih! Data Anda telah berhasil disimpan.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Visitor::query();

        // Filter pencarian nama dan asal instansi
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('asal_instansi', 'like', '%' . $request->search . '%');
            });
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
            'asal_instansi' => 'nullable|string|max:255',
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
            'asal_instansi' => 'nullable|string|max:255',
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

        // Create new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header style
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('D3D3D3');

        // Insert data
        $sheet->fromArray($data, null, 'A1');

        // Auto-size columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set filename
        $filename = 'data-tamu-' . date('Y-m-d') . '.xlsx';

        // Create writer and output
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
