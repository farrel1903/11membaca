<?php

namespace App\Exports;

use App\Models\Riwayat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RiwayatExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection()
    {
        // Mendapatkan data peminjaman dari model Riwayat
        return Riwayat::all(['id_pinjam', 'id_user', 'id_buku_induk', 'judul', 'kategori', 'isbn', 'tanggal_peminjaman']);
    }

    public function headings(): array
    {
        return [
            'ID Peminjaman',
            'ID Pengguna',
            'ID Buku Induk',
            'Judul Buku',
            'Kategori',
            'ISBN',
            'Tanggal Pinjam',
        ];
    }

    public function map($peminjaman): array
    {
        return [
            $peminjaman->id_pinjam,
            $peminjaman->id_user,
            $peminjaman->id_buku_induk,
            $peminjaman->judul,
            $peminjaman->kategori,
            "'" . $peminjaman->isbn, // Format ISBN sebagai teks
            $peminjaman->tanggal_peminjaman,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT, // Pastikan kolom ISBN diformat sebagai teks
        ];
    }
}
