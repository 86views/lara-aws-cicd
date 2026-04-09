@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Product Manager</h1>
    <a href="{{ route('products.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
        + Add Product
    </a>
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
                <td class="px-4 py-3 flex items-center space-x-2">
                    <a href="{{ route('products.edit', $product) }}"
                       class="text-blue-600 hover:underline text-xs font-medium">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                          onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-red-500 hover:underline text-xs font-medium">Delete</button>
                    </form>
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