<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;
    
    private $importedCount = 0;
    private $errors = [];
    private $failures = [];

    public function model(array $row)
    {
        // Check if product with same SKU exists
        $existingProduct = Product::where('sku', $row['sku'])->first();
        
        if ($existingProduct) {
            $this->errors[] = "SKU {$row['sku']} already exists. Product skipped.";
            return null;
        }

        $this->importedCount++;
        
        return new Product([
            'name' => $row['name'],
            'description' => $row['description'] ?? null,
            'price' => $row['price'],
            'sku' => $row['sku'],
            'qty' => $row['qty'] ?? 0,
            'type' => $row['type'] ?? null,
            'vendor' => $row['vendor'] ?? null,
            'image' => null, // Images need to be handled separately
            'tags' => $row['tags'] ?? null, // Will be set by rules
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'nullable|integer|min:0',
            'type' => 'nullable|string|max:255',
            'vendor' => 'nullable|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Product name is required',
            'sku.required' => 'SKU is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'qty.integer' => 'Quantity must be a whole number',
        ];
    }

    /**
     * Handle errors from the import
     */
    public function onError(Throwable $e)
    {
        $this->errors[] = $e->getMessage();
        Log::error('Import error: ' . $e->getMessage());
    }

    /**
     * Handle validation failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures[] = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values(),
            ];
        }
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFailures()
    {
        return $this->failures;
    }
}