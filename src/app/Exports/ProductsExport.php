<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $products;

    public function __construct($products = null)
    {
        $this->products = $products;
    }

    public function collection()
    {
        if ($this->products) {
            return $this->products;
        }
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Description',
            'Price',
            'SKU',
            'Quantity',
            'Type',
            'Vendor',
            'Tags',
            'Created Date',
            'Updated Date'
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            strip_tags($product->description), // Remove HTML tags from description
            $product->price,
            $product->sku,
            $product->qty,
            $product->type,
            $product->vendor,
            $product->tags,
            $product->created_at ? $product->created_at->format('Y-m-d H:i:s') : '',
            $product->updated_at ? $product->updated_at->format('Y-m-d H:i:s') : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:K1' => ['fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB']
            ]],
        ];
    }

    public function title(): string
    {
        return 'Products List';
    }
}