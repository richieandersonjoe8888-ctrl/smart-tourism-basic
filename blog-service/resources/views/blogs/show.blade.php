<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }} - Smart Tourism</title>
    <!-- Modern Styling and Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
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
<body class="bg-gray-50 min-h-screen text-gray-800 antialiased selection:bg-indigo-200 selection:text-indigo-900">

    @if(Auth::check() && Auth::user()->hasRole('admin'))
        <div class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex flex-wrap items-center justify-between gap-4 sticky top-0 z-50 shadow-md text-white">
            <div class="flex items-center gap-3">
                <span class="text-xl">🛠️</span>
                <div>
                    <p class="text-sm font-bold tracking-wide uppercase text-slate-400">Administrative Moderation Panel</p>
                    <p class="text-xs text-slate-300">
                        Current Status: 
                        <span class="font-semibold uppercase tracking-wider px-2 py-0.5 rounded text-[10px] 
                            {{ $blog->status === 'approved' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : '' }}
                            {{ $blog->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : '' }}
                            {{ $blog->status === 'rejected' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/30' : '' }}
                            {{ $blog->status === 'disabled' ? 'bg-red-500/20 text-red-400 border border-red-500/30' : '' }}
                        ">
                            {{ $blog->status }}
                        </span>
                        @if($blog->moderation_reason)
                            <span class="text-slate-400 block mt-1">Reason: "{{ $blog->moderation_reason }}"</span>
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 flex-wrap">
                <!-- Action Buttons depending on status -->
                @if($blog->status === 'pending' || $blog->status === 'rejected')
                    <form action="{{ route('admin.blogs.approve', $blog->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-4 py-2 rounded-full transition shadow-sm">
                            Approve & Publish
                        </button>
                    </form>
                @endif

                @if($blog->status === 'pending')
                    <form action="{{ route('admin.blogs.reject', $blog->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold px-4 py-2 rounded-full transition shadow-sm">
                            Reject
                        </button>
                    </form>
                @endif

                @if($blog->status === 'approved')
                    <form action="{{ route('admin.blogs.disable', $blog->id) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="text" name="moderation_reason" placeholder="Reason for disabling..." required
                            class="text-xs rounded-full border-slate-700 bg-slate-850 text-white px-3 py-1.5 focus:ring-red-500 focus:border-red-500 min-w-[200px] border">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-full transition shadow-sm whitespace-nowrap">
                            Disable (Takedown)
                        </button>
                    </form>
                @endif
                
                @if($blog->status === 'disabled')
                    <form action="{{ route('admin.blogs.approve', $blog->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-4 py-2 rounded-full transition shadow-sm">
                            Re-Enable Publication
                        </button>
                    </form>
                @endif
                
                <a href="{{ config('services.auth_service.url') }}/admin/panel" class="text-xs text-slate-400 hover:text-white transition font-medium underline ml-2">
                    Back to Admin Panel &rarr;
                </a>
            </div>
        </div>
    @endif

    <!-- Universal Navigation Header -->
    <x-universal-header />

    <!-- Hero Banner for Blog -->
    <div class="relative w-full h-[50vh] min-h-[400px] bg-slate-900">
        @if($blog->image)
            <img src="{{ asset('storage/' . $blog->image) }}" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay" alt="{{ $blog->title }}">
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 opacity-80"></div>
        @endif
        
        <!-- Subtle pattern overlay -->
        <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

        <div class="absolute inset-0 flex items-center justify-center pt-16">
            <div class="max-w-4xl mx-auto px-6 text-center z-10">
                <div class="mb-4 flex flex-wrap justify-center gap-2">
                    @foreach($blog->tags as $tag)
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full text-xs font-semibold text-white uppercase tracking-widest shadow-sm">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-6 leading-tight drop-shadow-lg">
                    {{ $blog->title }}
                </h1>
                
                <div class="flex items-center justify-center space-x-4 text-slate-200">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-white text-indigo-900 flex items-center justify-center font-bold text-lg shadow-md ring-2 ring-white/50">
                            {{ strtoupper(substr($blog->user->name ?? 'V', 0, 1)) }}
                        </div>
                        <span class="ml-3 font-semibold text-lg drop-shadow-md">{{ $blog->user->name ?? 'Verified Vendor' }}</span>
                    </div>
                    <span class="opacity-50">&bull;</span>
                    <span class="text-sm font-medium drop-shadow-md">{{ $blog->created_at->format('F j, Y') }}</span>
                    <span class="opacity-50">&bull;</span>
                    <span class="text-sm font-medium drop-shadow-md flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ max(1, ceil(str_word_count(strip_tags($blog->content)) / 200)) }} {{ __('min read') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Content Article -->
    <main class="max-w-3xl mx-auto px-6 py-16 md:py-24">
        <article class="prose prose-lg prose-indigo md:prose-xl mx-auto text-slate-700 leading-relaxed bg-white p-8 md:p-14 rounded-3xl shadow-xl shadow-slate-200/50 -mt-32 relative z-20 border border-slate-100">
            {!! nl2br(e($blog->content)) !!}
        </article>
        
        <!-- Back Navigation -->
        <div class="mt-12 text-center">
            <a href="{{ route('blogs.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition-colors shadow-sm hover:shadow-md">
                &larr; {{ __('Back to Discover') }}
            </a>
        </div>
    </main>
    
</body>
</html>
