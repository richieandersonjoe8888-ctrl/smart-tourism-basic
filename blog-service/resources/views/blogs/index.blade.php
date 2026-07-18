<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Tourism - Discover</title>
    <!-- Modern Styling and Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 min-h-screen text-gray-800">

    <!-- Universal Navigation Header -->
    <x-universal-header />

    <!-- Header Hero Section -->
    <header class="pt-24 pb-16 text-center px-4 relative overflow-hidden">
        <!-- Abstract decorative blobs -->
        <div class="absolute top-0 left-1/4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="relative z-10">
            <span class="text-sm font-bold tracking-widest text-indigo-600 uppercase mb-4 block">{{ __('Travel & Discover') }}</span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 tracking-tight mb-6">{!! __('Explore <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500">Amazing Places</span>') !!}</h1>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto font-light leading-relaxed">{{ __('Read carefully curated stories and guides from our verified vendors to make your next trip absolutely unforgettable.') }}</p>
        </div>
    </header>

    <!-- Main Content: Blog Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-32">
        @if($blogs->isEmpty())
            <div class="text-center py-20 bg-white/50 rounded-3xl border border-dashed border-gray-300 max-w-3xl mx-auto">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20"></path></svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No blogs published yet') }}</h3>
                <p class="text-gray-500 text-md">{{ __('Check back soon! Our vendors are writing up some great content.') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($blogs as $blog)
                    <article class="bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden flex flex-col group border border-slate-100/60 ring-1 ring-slate-900/5">
                        
                        <!-- Blog Image Container -->
                        <div class="relative h-64 w-full overflow-hidden bg-slate-100">
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-purple-100 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="absolute top-4 left-4 z-10">
                                <span class="px-4 py-1.5 bg-white/95 backdrop-blur-md text-xs font-bold text-indigo-700 rounded-full shadow-sm tracking-widest uppercase">
                                    {{ __('Featured') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Blog Content -->
                        <div class="p-8 flex-1 flex flex-col relative bg-white">
                            <a href="{{ route('blogs.show', $blog->id) }}" class="block">
                                <h2 class="text-2xl font-bold text-slate-900 mb-4 group-hover:text-indigo-600 transition-colors duration-200 leading-tight">
                                    {{ $blog->title }}
                                </h2>
                            </a>
                            <div class="text-slate-600 text-sm mb-8 flex-1 leading-relaxed line-clamp-3">
                                {!! nl2br(e(strip_tags($blog->content))) !!}
                            </div>
                            
                            <!-- Author Footer and Read More Button -->
                            <div class="flex items-center justify-between mt-auto pt-5 border-t border-slate-100">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-md ring-2 ring-white shadow-indigo-200">
                                        {{ strtoupper(substr($blog->user->name ?? 'V', 0, 1)) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-bold text-slate-900">{{ $blog->user->name ?? 'Verified Vendor' }}</p>
                                        <p class="text-xs text-slate-500">{{ $blog->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                <a href="{{ route('blogs.show', $blog->id) }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                    {{ __('Read Full') }} <span aria-hidden="true" class="ml-1">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>
