@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Products
            </a>
            <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">Product ID: #{{ $product->id }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('products.edit', $product) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                Edit Product
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" 
                  onsubmit="return confirm('Delete this product permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    Delete Product
                </button>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Product Image Section -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Product Image</h2>
            
            @if($product->image)
                <div class="flex justify-center items-center bg-gray-50 rounded-lg p-4">
                    <img src="{{ Storage::url($product->image) }}" 
                         alt="{{ $product->name }}"
                         class="max-w-full h-auto rounded-lg shadow-md"
                         style="max-height: 400px;">
                </div>
            @else
                <div class="flex justify-center items-center bg-gray-100 rounded-lg p-8">
                    <div class="text-center">
                        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-gray-500">No image available</p>
                        <a href="{{ route('products.edit', $product) }}" 
                           class="mt-3 inline-block text-blue-600 hover:text-blue-800 text-sm">
                            Add Image
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Product Details Section -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Product Details</h2>
            
            <div class="space-y-4">
                <div class="border-b pb-3">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Product Name</label>
                    <p class="text-gray-800 font-medium mt-1">{{ $product->name }}</p>
                </div>

                <div class="border-b pb-3">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">SKU</label>
                    <p class="text-gray-800 font-mono text-sm mt-1">{{ $product->sku }}</p>
                </div>

                <div class="border-b pb-3">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Price</label>
                    <p class="text-2xl font-bold text-green-600 mt-1">${{ number_format($product->price, 2) }}</p>
                </div>

                <div class="border-b pb-3">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Vendor</label>
                    <p class="text-gray-800 mt-1">{{ $product->vendor ?? 'Not specified' }}</p>
                </div>

                <div class="border-b pb-3">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Quantity</label>
                    <div class="mt-1">
                        @if($product->qty <= 0)
                            <span class="inline-block bg-red-100 text-red-700 text-sm px-2 py-1 rounded">
                                Out of Stock
                            </span>
                        @elseif($product->qty <= 10)
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-sm px-2 py-1 rounded">
                                Low Stock: {{ $product->qty }} units
                            </span>
                        @else
                            <span class="inline-block bg-green-100 text-green-700 text-sm px-2 py-1 rounded">
                                In Stock: {{ $product->qty }} units
                            </span>
                        @endif
                    </div>
                </div>

                <div class="border-b pb-3">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Product Type</label>
                    <p class="text-gray-800 mt-1">
                        <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm">
                            {{ $product->type ?? 'General' }}
                        </span>
                    </p>
                </div>

                <div class="border-b pb-3">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tags</label>
                    <div class="mt-1">
                        @if($product->tags)
                            @foreach(explode(',', $product->tags) as $tag)
                                <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full mr-1 mb-1">
                                    {{ trim($tag) }}
                                </span>
                            @endforeach
                        @else
                            <p class="text-gray-400 text-sm">No tags assigned</p>
                        @endif
                    </div>
                </div>

                @if($product->description)
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Description</label>
                    <div class="mt-2 prose prose-sm max-w-none">
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Additional Information Section (if needed) -->
@if($product->meta_data || $product->specifications)
<div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h2>
        
        @if($product->specifications)
        <div class="mb-4">
            <h3 class="text-md font-medium text-gray-700 mb-2">Specifications</h3>
            <div class="bg-gray-50 rounded p-4">
                {!! nl2br(e($product->specifications)) !!}
            </div>
        </div>
        @endif
        
        @if($product->meta_data)
        <div>
            <h3 class="text-md font-medium text-gray-700 mb-2">Meta Data</h3>
            <div class="bg-gray-50 rounded p-4">
                {!! nl2br(e($product->meta_data)) !!}
            </div>
        </div>
        @endif
    </div>
</div>
@endif

<!-- Stock History or Related Actions -->
<div class="mt-6 flex justify-end space-x-3">
    <a href="{{ route('products.index') }}" 
       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
        Back to List
    </a>
    <a href="{{ route('products.edit', $product) }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
        Edit Product
    </a>
</div>
@endsection