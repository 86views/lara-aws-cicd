<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Tag Manager</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Quill.js (Rich Editor) -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <style>
        .ql-container { min-height: 120px; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
               <a href="{{ route('products.index') }}">
    <span class="text-xl font-bold text-blue-700 tracking-tight">
        Product Tag Manager
    </span>
</a>>
                <div class="flex space-x-2">
                    <a href="{{ route('products.index') }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors 
                    {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Product Manager
                    </a>

                    <a href="{{ route('rules.index') }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors 
                    {{ request()->routeIs('rules.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Rule Manager
                    </a>


                    <!-- Add this link to your navigation menu -->
<a href="{{ route('analytics.dashboard') }}" 
   class="px-4 py-2 rounded-md text-sm font-medium transition-colors
   {{ request()->routeIs('analytics.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
    </svg>
    Analytics
</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 pt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-4 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-600 font-bold ml-4">×</button>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

</body>
</html>