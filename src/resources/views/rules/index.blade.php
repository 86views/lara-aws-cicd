@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Rule Manager</h1>
    <a href="{{ route('rules.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
        + Add Rule
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Rule Name</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Apply Tags</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Action (Edit)</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($rules as $rule)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $rule->name }}</td>
                <td class="px-4 py-3">
                    @foreach(explode(',', $rule->apply_tags) as $tag)
                        <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full mr-1">
                            {{ trim($tag) }}
                        </span>
                    @endforeach
                </td>
                <td class="px-4 py-3 flex items-center space-x-2">
                    <a href="{{ route('rules.edit', $rule) }}"
                       class="text-blue-600 hover:underline text-xs font-medium">Edit</a>
                    <form action="{{ route('rules.destroy', $rule) }}" method="POST"
                          onsubmit="return confirm('Delete this rule?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-xs font-medium">Delete</button>
                    </form>
                </td>
                <td class="px-4 py-3">
                    <form action="{{ route('rules.apply', $rule) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1.5 rounded font-medium transition">
                            Apply Rule
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                    No rules found. <a href="{{ route('rules.create') }}" class="text-blue-600 underline">Create one</a>.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($rules->hasPages())
<div class="mt-4">{{ $rules->links() }}</div>
@endif
@endsection