<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Service Portal</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">🌐</span>
                    <span class="font-bold text-lg text-gray-800 tracking-tight">Smart Tourism Ecosystem</span>
                </div>
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span class="bg-green-100 text-green-800 font-semibold px-2.5 py-0.5 rounded-full text-xs">Vendor Node</span>
                    <span class="font-medium">{{ Auth::user()->email ?? 'Authenticated Vendor' }}</span>
                </div>
            </div>
        </div>
    </nav>
<div class="flex items-center space-x-4 text-sm text-gray-600">
    <span class="bg-green-100 text-green-800 font-semibold px-2.5 py-0.5 rounded-full text-xs">Vendor Node</span>
    <span class="font-medium">{{ Auth::user()->name }}</span>
    
    <a href="http://127.0.0.1:8888/profile" class="text-indigo-600 hover:text-indigo-800 hover:underline font-medium">
        Account Settings
    </a>
    
    <form method="POST" action="http://127.0.0.1:8888/logout" class="inline">
        @csrf
        <button type="submit" class="text-red-600 hover:text-red-800 font-medium hover:underline ml-2">Log Out</button>
    </form>
</div>
    <main>
        @yield('content')
    </main>

</body>
</html>