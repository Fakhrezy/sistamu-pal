<?php

namespace App\Exports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VisitorExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $tanggal_mulai;
    protected $tanggal_akhir;
    protected $kategori;

    public function __construct($tanggal_mulai = null, $tanggal_akhir = null, $kategori = null)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_akhir = $tanggal_akhir;
        $this->kategori = $kategori;
    }

    public function query()
    {
        $query = Visitor::query();

        if ($this->tanggal_mulai) {
            $query->where('tanggal', '>=', $this->tanggal_mulai);
        }
        if ($this->tanggal_akhir) {
            $query->where('tanggal', '<=', $this->tanggal_akhir);
        }
        if ($this->kategori && $this->kategori != 'semua') {
            $query->where('kategori', $this->kategori);
        }

        return $query->orderBy('tanggal', 'desc')->orderBy('jam', 'desc');
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jam',
            'Nama',
            'Kategori',
            'Tujuan Kunjungan',
            'Kontak'
        ];
    }

    public function map($visitor): array
    {
        return [
            date('d/m/Y', strtotime($visitor->tanggal)),
            date('H:i', strtotime($visitor->jam)),
            $visitor->nama,
            ucfirst($visitor->kategori),
            $visitor->tujuan_kunjungan,
            $visitor->kontak
        ];
    }
}
