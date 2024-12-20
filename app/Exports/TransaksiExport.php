<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection()
    {
        // Mendapatkan data peminjaman dari model Transaksi
        return Transaksi::select('id_transaksi', 'nis_nik', 'tanggal_peminjaman', 'tanggal_pengembalian')->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'NIS/NIK',
            'Tanggal Peminjaman',
            'Tanggal Pengembalian',
        ];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->id_transaksi,
            "'" . $transaksi->nis_nik, // Format NIS/NIK sebagai teks untuk menghindari notasi ilmiah
            $transaksi->tanggal_peminjaman,
            $transaksi->tanggal_pengembalian,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Format kolom NIS/NIK sebagai teks
        ];
    }
}
