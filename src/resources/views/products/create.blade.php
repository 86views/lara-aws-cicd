@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Add Product</h1>
    <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:underline">← Back to list</a>
</div>

<div class="bg-white shadow rounded-lg p-6 max-w-3xl">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                   placeholder="Enter product name">
        </div>

        <!-- Product Description (Quill Editor) -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Description</label>
            <div id="quill-editor" class="bg-white border border-gray-300 rounded-md"></div>
            <input type="hidden" name="description" id="description-input">
        </div>

        <!-- Price & SKU -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Price <span class="text-red-500">*</span></label>
                <input type="number" name="price" step="0.01" value="{{ old('price') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="0.00">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product SKU <span class="text-red-500">*</span></label>
                <input type="text" name="sku" value="{{ old('sku') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="e.g. WA001">
            </div>
        </div>

        <!-- Qty & Type -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Qty <span class="text-red-500">*</span></label>
                <input type="number" name="qty" value="{{ old('qty', 0) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                <input type="text" name="type" value="{{ old('type') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="e.g. Type1">
            </div>
        </div>

        <!-- Vendor -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Vendor</label>
            <input type="text" name="vendor" value="{{ old('vendor') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                   placeholder="e.g. Supp.X">
        </div>

        <!-- Product Image -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Product Tags (non-editable) -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Tags
                <span class="text-gray-400 text-xs">(set automatically by rules, non-editable)</span>
            </label>
            <input type="text" disabled value=""
                   class="w-full border border-gray-200 bg-gray-50 rounded-md px-3 py-2 text-sm text-gray-400 cursor-not-allowed"
                   placeholder="Tags will be applied by rules">
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium text-sm transition">
            SUBMIT PRODUCT
        </button>
    </form>
</div>

<script>
    const quill = new Quill('#quill-editor', { theme: 'snow' });
    document.querySelector('form').addEventListener('submit', function () {
        document.getElementById('description-input').value = quill.root.innerHTML;
    });
</script>
@endsection