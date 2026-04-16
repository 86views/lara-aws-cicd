@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Analytics Dashboard</h1>
        <p class="text-gray-600 mt-2">View product tagging analytics and performance metrics</p>
    </div>

    <!-- Overall Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Products</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $overallStats['total_products'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Rules</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $overallStats['total_rules'] }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Products with Tags</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $overallStats['products_with_tags'] }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-5-5A2 2 0 013 12.5V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Unique Tags</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $overallStats['unique_tags'] }}</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Export Reports</h2>
        <div class="flex flex-wrap gap-3">

         <!-- Product Export -->
        <a href="{{ route('products.export.excel') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
            📦 Export All Products (Excel)
        </a>
        <a href="{{ route('products.export.csv') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
            📄 Export All Products (CSV)
        </a>
            <a href="{{ route('analytics.export', ['type' => 'tags', 'format' => 'csv']) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                📊 Export Tag Distribution (CSV)
            </a>
            <a href="{{ route('analytics.export', ['type' => 'tags', 'format' => 'excel']) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                📊 Export Tag Distribution (Excel)
            </a>
            <a href="{{ route('analytics.export', ['type' => 'rules', 'format' => 'csv']) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                📈 Export Rule Metrics (CSV)
            </a>
            <a href="{{ route('analytics.export', ['type' => 'vendors', 'format' => 'csv']) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                🏭 Export Vendor Stats (CSV)
            </a>
            <a href="{{ route('analytics.export', ['type' => 'types', 'format' => 'csv']) }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition">
                📦 Export Type Stats (CSV)
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Tag Distribution Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Tag Distribution Across Products</h2>
            @if(count($tagDistribution) > 0)
                <canvas id="tagDistributionChart" class="w-full h-64"></canvas>
            @else
                <p class="text-gray-500 text-center py-8">No tags found</p>
            @endif
        </div>

        <!-- Most Frequent Tags -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Most Frequently Used Tags</h2>
            @if(count($frequentTags) > 0)
                <canvas id="frequentTagsChart" class="w-full h-64"></canvas>
            @else
                <p class="text-gray-500 text-center py-8">No tags found</p>
            @endif
        </div>
    </div>

    <!-- Rule Effectiveness Metrics -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Rule Effectiveness Metrics</h2>
        @if(count($ruleMetrics) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rule Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apply Tags</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products Tagged</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Effectiveness</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sample Products</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($ruleMetrics as $rule)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $rule['name'] }}</td>
                                <td class="px-6 py-4">
                                    @foreach(explode(',', $rule['apply_tags']) as $tag)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">{{ trim($tag) }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $rule['product_count'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-1 h-2 bg-gray-200 rounded-full mr-2 w-24">
                                            <div class="h-2 bg-green-600 rounded-full" style="width: {{ $rule['effectiveness_percentage'] }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600">{{ $rule['effectiveness_percentage'] }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if(count($rule['affected_products']) > 0)
                                        {{ implode(', ', array_slice($rule['affected_products'], 0, 3)) }}
                                        @if(count($rule['affected_products']) > 3)
                                            +{{ count($rule['affected_products']) - 3 }} more
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No rules found</p>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Vendor Statistics -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Product Count by Vendor with Tag Breakdown</h2>
            @if(count($vendorStats) > 0)
                <div class="space-y-4">
                    @foreach($vendorStats as $vendor)
                        <div class="border-b pb-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-800">{{ $vendor->vendor }}</span>
                                <span class="text-sm text-gray-600">{{ $vendor->total_products }} products</span>
                            </div>
                            <div class="flex flex-wrap gap-1">
                                @foreach($vendor->tag_breakdown as $tag => $count)
                                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                                        {{ $tag }} ({{ $count }})
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No vendor data found</p>
            @endif
        </div>

        <!-- Type Statistics -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Product Count by Type with Tag Breakdown</h2>
            @if(count($typeStats) > 0)
                <div class="space-y-4">
                    @foreach($typeStats as $type)
                        <div class="border-b pb-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-800">{{ $type->type }}</span>
                                <span class="text-sm text-gray-600">{{ $type->total_products }} products</span>
                            </div>
                            <div class="flex flex-wrap gap-1">
                                @foreach($type->tag_breakdown as $tag => $count)
                                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                                        {{ $tag }} ({{ $count }})
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No type data found</p>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js for charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Tag Distribution Chart
    @if(count($tagDistribution) > 0)
    const tagCtx = document.getElementById('tagDistributionChart').getContext('2d');
    new Chart(tagCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($tagDistribution)) !!},
            datasets: [{
                label: 'Number of Products',
                data: {!! json_encode(array_values($tagDistribution)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' products';
                        }
                    }
                }
            }
        }
    });
    @endif

    // Most Frequent Tags Chart
    @if(count($frequentTags) > 0)
    const freqCtx = document.getElementById('frequentTagsChart').getContext('2d');
    new Chart(freqCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($frequentTags)) !!},
            datasets: [{
                data: {!! json_encode(array_values($frequentTags)) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' products';
                        }
                    }
                }
            }
        }
    });
    @endif
</script>
@endsection