<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use App\Exports\ProductsTemplateExport;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'sku'         => 'required|string|unique:products,sku',
            'qty'         => 'required|integer|min:0',
            'type'        => 'nullable|string|max:255',
            'vendor'      => 'nullable|string|max:255',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    /**
     * Display the specified resource.
     */
   public function show(Product $product)
{
    // If you want to show the individual product page
    return view('products.show', compact('product'));
    
    // OR if you need to redirect for certain conditions:
    // if (!$product->is_active) {
    //     return redirect()->route('products.index')->with('error', 'Product not available');
    // }
    // return view('products.show', compact('product'));
}
    
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'sku'         => 'required|string|unique:products,sku,' . $product->id,
            'qty'         => 'required|integer|min:0',
            'type'        => 'nullable|string|max:255',
            'vendor'      => 'nullable|string|max:255',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted.');
    }


    public function exportExcel()
    {
        try {
            return Excel::download(new ProductsExport(), 'products_' . date('Y-m-d_H-i-s') . '.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    /**
     * Export products to CSV
     */
    public function exportCsv()
    {
        try {
            return Excel::download(new ProductsExport(), 'products_' . date('Y-m-d_H-i-s') . '.csv', \Maatwebsite\Excel\Excel::CSV);
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        try {
            return Excel::download(new ProductsTemplateExport(), 'products_import_template.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Template download failed: ' . $e->getMessage());
        }
    }

    /**
     * Show import form
     */
    public function showImportForm()
    {
        return view('products.import');
    }

    /**
     * Import products from Excel/CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        try {
            $import = new ProductsImport();
            Excel::import($import, $request->file('file'));
            
            $importedCount = $import->getImportedCount();
            $errors = $import->getErrors();
            $failures = $import->getFailures();
            
            $message = "Successfully imported {$importedCount} products.";
            
            if (!empty($errors) || !empty($failures)) {
                session()->flash('import_errors', ['errors' => $errors, 'failures' => $failures]);
                return redirect()->route('products.index')
                    ->with('warning', $message . ' However, some rows had issues. Click "View Details" for more info.');
            }
            
            return redirect()->route('products.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
