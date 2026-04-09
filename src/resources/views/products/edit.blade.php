@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Product</h1>
    <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:underline">← Back to list</a>
</div>

<div class="bg-white shadow rounded-lg p-6 max-w-3xl">
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Description</label>
            <div id="quill-editor" class="bg-white border border-gray-300 rounded-md"></div>
            <input type="hidden" name="description" id="description-input">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Price <span class="text-red-500">*</span></label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product SKU <span class="text-red-500">*</span></label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Qty <span class="text-red-500">*</span></label>
                <input type="number" name="qty" value="{{ old('qty', $product->qty) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                <input type="text" name="type" value="{{ old('type', $product->type) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Vendor</label>
            <input type="text" name="vendor" value="{{ old('vendor', $product->vendor) }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ Storage::url($product->image) }}" alt="Current Image"
                         class="h-20 w-20 object-cover rounded border">
                    <p class="text-xs text-gray-400 mt-1">Current image. Upload new to replace.</p>
                </div>
            @endif
            <input type="file" name="image" accept="image/*"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Tags — non-editable display -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Tags
                <span class="text-gray-400 text-xs">(managed by rules only)</span>
            </label>
            <input type="text" disabled value="{{ $product->tags }}"
                   class="w-full border border-gray-200 bg-gray-50 rounded-md px-3 py-2 text-sm text-gray-500 cursor-not-allowed">
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium text-sm transition">
            UPDATE PRODUCT
        </button>
    </form>
</div>

<script>
    const quill = new Quill('#quill-editor', { theme: 'snow' });
    quill.root.innerHTML = `{!! addslashes($product->description ?? '') !!}`;
    document.querySelector('form').addEventListener('submit', function () {
        document.getElementById('description-input').value = quill.root.innerHTML;
    });
</script>
@endsection