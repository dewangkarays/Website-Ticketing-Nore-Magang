<?php

namespace App\Exports;

use App\Model\Patchlist;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PatchlistExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Patchlist',
            'Prioritas',
            'Tanggal Request',
            'Kesulitan',
            'Status',
            'Tanggal Patch',
            'Keterangan'
        ];
    }

    public function map($row): array
    {
        $status = [
            '0' => 'Hold',
            '1' => 'Queue',
            '2' => 'In Progress',
            '3' => 'Done Test Server',
            '4' => 'Production',
        ];
    
        $kesulitan = [
            '0' => 'Sangat Tinggi',
            '1' => 'Tinggi',
            '2' => 'Sedang',
            '3' => 'Rendah',
        ];

        $tanggalRequest = $row->created_at->format('Y-m-d');

        $tanggalPatch = '-';
        if ($row->tanggal_patch !== null) {
            $tanggalPatch = (new \DateTime($row->tanggal_patch))->format('Y-m-d');
        }

        return [
            'ID' => $row->id,
            'Patchlist' => $row->patchlist,
            'Prioritas' => $row->prioritas,
            'Tanggal Request' => $tanggalRequest,
            'Kesulitan' => $kesulitan[$row->kesulitan] ?? '',
            'Status' => $status[$row->status] ?? '',
            'Tanggal Patch' => $tanggalPatch,
            'Keterangan' => $row->keterangan,
        ];
    }
}
