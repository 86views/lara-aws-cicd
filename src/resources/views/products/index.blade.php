@extends('layouts.app')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    {{-- Left: Title --}}
    <div class="flex items-center gap-3">
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Product Manager</h1>
        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
            {{ $products->total() ?? 0 }} items
        </span>
    </div>

    {{-- Right: Actions Group --}}
    <div class="flex items-center gap-2">
        {{-- Add Product Button --}}
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="hidden sm:inline">Add Product</span>
            <span class="sm:hidden">Add</span>
        </a>

        {{-- Import Button --}}
        <a href="{{ route('products.import.form') }}"
           class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 hover:text-gray-900 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <span class="hidden sm:inline">Import</span>
        </a>

        {{-- Export Dropdown --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" 
                    class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 hover:text-gray-900 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span class="hidden sm:inline">Export</span>
                <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <div x-show="open" 
                 x-cloak
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="py-1">
                    <a href="{{ route('products.export.excel') }}" 
                       class="group flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                        <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm0 18H6V4h7v5h5v11z"/>
                        </svg>
                        Excel (.xlsx)
                    </a>
                    <a href="{{ route('products.export.csv') }}" 
                       class="group flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                        <svg class="h-4 w-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm0 18H6V4h7v5h5v11z"/>
                        </svg>
                        CSV (.csv)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <!-- <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th> -->
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Product ID</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Product Name</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">SKU</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Price</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Vendor</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Qty</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Type</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Tags</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <!-- <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td> -->
                <td class="px-4 py-3">
                    <a href="{{ route('products.show', $product) }}" 
                       class="text-blue-600 hover:text-blue-800 hover:underline font-mono text-sm">
                        {{ $product->id }}
                    </a>
                </td>
                <td class="px-4 py-3">
                    <a href="{{ route('products.show', $product) }}" 
                       class="font-medium text-gray-800 hover:text-blue-600 hover:underline">
                        {{ $product->name }}
                    </a>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $product->sku }}</td>
                <td class="px-4 py-3 text-gray-600 font-medium">${{ number_format($product->price, 2) }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $product->vendor ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $product->qty ?? '—' }}</td>
                <td class="px-4 py-3">
                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded-full">
                        {{ $product->type ?? '—' }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    @if($product->tags)
                        @foreach(explode(',', $product->tags) as $tag)
                            <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full mr-1 mb-1">
                                {{ trim($tag) }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-gray-400 text-xs">No tags</span>
                    @endif
                </td>
              <td class="px-4 py-3">
    <div class="flex items-center space-x-1">
        <!-- View Button -->
        <a href="{{ route('products.show', $product) }}" 
           class="inline-flex items-center justify-center p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
           title="View">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
        </a>

        <!-- Edit Button -->
        <a href="{{ route('products.edit', $product) }}" 
           class="inline-flex items-center justify-center p-1.5 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-lg transition-colors duration-200" 
           title="Edit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
        </a>

        <!-- Delete Button -->
        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('Delete this product?')"
                    class="inline-flex items-center justify-center p-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                    title="Delete">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </form>
    </div>
</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="px-4 py-8 text-center text-gray-400">
                    No products found. <a href="{{ route('products.create') }}" class="text-blue-600 underline">Add one</a>.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($products->hasPages())
<div class="mt-4">{{ $products->links() }}</div>
@endif
@endsection