@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Create Rule</h1>
    <a href="{{ route('rules.index') }}" class="text-sm text-blue-600 hover:underline">← Back to list</a>
</div>

<div class="bg-white shadow rounded-lg p-6 max-w-3xl">
    <form action="{{ route('rules.store') }}" method="POST" id="rule-form">
        @csrf

        <!-- Rule Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Rule Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                   placeholder="e.g. VIP Products">
        </div>

        <!-- Rule Conditions -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Rule Conditions <span class="text-red-500">*</span>
                <span class="text-gray-400 text-xs font-normal">(All conditions must match)</span>
            </label>

            <div id="conditions-wrapper" class="space-y-3">
                <!-- Condition Row Template (first row) -->
                <div class="condition-row flex items-center gap-2 bg-gray-50 p-3 rounded-md border border-gray-200">
                    <select name="conditions[0][product_selector]"
                            class="border border-gray-300 rounded-md px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Choose Selector</option>
                        <option value="type">Type</option>
                        <option value="sku">SKU</option>
                        <option value="vendor">Vendor</option>
                        <option value="price">Price</option>
                        <option value="qty">Qty</option>
                    </select>

                    <select name="conditions[0][operator]"
                            class="border border-gray-300 rounded-md px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Operator</option>
                        <option value="==">==</option>
                        <option value=">">&gt;</option>
                        <option value="<">&lt;</option>
                    </select>

                    <input type="text" name="conditions[0][value]" placeholder="Value"
                           class="flex-1 border border-gray-300 rounded-md px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

                    <button type="button" onclick="removeCondition(this)"
                            class="text-red-400 hover:text-red-600 font-bold text-lg leading-none px-1">×</button>
                </div>
            </div>

            <button type="button" onclick="addCondition()"
                    class="mt-3 flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                <span class="text-lg leading-none">+</span> Add More Conditions
            </button>
        </div>

        <!-- Apply Tags -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Apply Tags <span class="text-red-500">*</span>
                <span class="text-gray-400 text-xs font-normal">(comma-separated)</span>
            </label>
            <input type="text" name="apply_tags" value="{{ old('apply_tags') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                   placeholder="e.g. VIP, Gold, Premium">
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium text-sm transition">
            SAVE RULE
        </button>
    </form>
</div>

<script>
let conditionIndex = 1;

function addCondition() {
    const wrapper = document.getElementById('conditions-wrapper');
    const idx = conditionIndex++;
    const row = document.createElement('div');
    row.className = 'condition-row flex items-center gap-2 bg-gray-50 p-3 rounded-md border border-gray-200';
    row.innerHTML = `
        <select name="conditions[${idx}][product_selector]"
                class="border border-gray-300 rounded-md px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Choose Selector</option>
            <option value="type">Type</option>
            <option value="sku">SKU</option>
            <option value="vendor">Vendor</option>
            <option value="price">Price</option>
            <option value="qty">Qty</option>
        </select>
        <select name="conditions[${idx}][operator]"
                class="border border-gray-300 rounded-md px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Operator</option>
            <option value="==">==</option>
            <option value=">">&gt;</option>
            <option value="<">&lt;</option>
        </select>
        <input type="text" name="conditions[${idx}][value]" placeholder="Value"
               class="flex-1 border border-gray-300 rounded-md px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="button" onclick="removeCondition(this)"
                class="text-red-400 hover:text-red-600 font-bold text-lg leading-none px-1">×</button>
    `;
    wrapper.appendChild(row);
}

function removeCondition(btn) {
    const rows = document.querySelectorAll('.condition-row');
    if (rows.length > 1) {
        btn.closest('.condition-row').remove();
    } else {
        alert('At least one condition is required.');
    }
}
</script>
@endsection