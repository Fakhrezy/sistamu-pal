<?php

namespace App\Exports;

use App\Models\Visitor;

class VisitorExport
{
    protected $tanggal_mulai;
    protected $tanggal_akhir;
    protected $kategori;
    protected $search;

    public function __construct($tanggal_mulai = null, $tanggal_akhir = null, $kategori = null, $search = null)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_akhir = $tanggal_akhir;
        $this->kategori = $kategori;
        $this->search = $search;
    }

    public function export()
    {
        $query = Visitor::query();

        // Filter pencarian nama
        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }

        if ($this->tanggal_mulai) {
            $query->where('tanggal', '>=', $this->tanggal_mulai);
        }
        if ($this->tanggal_akhir) {
            $query->where('tanggal', '<=', $this->tanggal_akhir);
        }
        if ($this->kategori && $this->kategori != 'semua') {
            $query->where('kategori', $this->kategori);
        }

        $visitors = $query->orderBy('tanggal', 'desc')->orderBy('jam', 'desc')->get();

        $data = [];

        // Header
        $data[] = [
            'No',
            'Tanggal',
            'Jam Check In',
            'Jam Check Out',
            'Nama',
            'Kategori',
            'Tujuan Kunjungan',
            'Kontak',
            'Status'
        ];

        // Data rows
        $no = 1;
        foreach ($visitors as $visitor) {
            $data[] = [
                $no++,
                date('d/m/Y', strtotime($visitor->tanggal)),
                date('H:i', strtotime($visitor->jam)),
                $visitor->jam_checkout ? date('H:i', strtotime($visitor->jam_checkout)) : '-',
                $visitor->nama,
                ucfirst($visitor->kategori),
                $visitor->tujuan_kunjungan,
                $visitor->kontak,
                ucfirst($visitor->status)
            ];
        }

        return $data;
    }
}
