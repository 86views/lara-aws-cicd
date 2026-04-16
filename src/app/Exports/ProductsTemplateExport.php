<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                'Sample Product 1',
                'This is a sample product description',
                '99.99',
                'SKU001',
                '10',
                'Electronics',
                'Supplier A',
                'tag1, tag2, tag3'
            ],
            [
                'Sample Product 2',
                'Another sample product',
                '49.99',
                'SKU002',
                '25',
                'Clothing',
                'Supplier B',
                'premium, new'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'name *',
            'description',
            'price *',
            'sku *',
            'qty',
            'type',
            'vendor',
            'tags'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11]],
            'A1:H1' => ['fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5']
            ]],
        ];
    }
}