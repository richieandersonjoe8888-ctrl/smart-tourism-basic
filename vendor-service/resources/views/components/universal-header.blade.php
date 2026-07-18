@php
    $authPort = 8000;
    $vendorPort = 8001;
    $blogPort = 8002;
    $baseUrl = 'http://127.0.0.1';
@endphp

<nav class="glass-card sticky top-0 z-50 shadow-sm transition-all duration-300" style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.3);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex-shrink-0 flex items-center gap-4">
                <a href="{{ $baseUrl }}:{{ $blogPort }}/blogs" class="flex items-center gap-2 cursor-pointer transition-transform hover:scale-105">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">SmartTourism</span>
                </a>
                
                <!-- Main Links -->
                <div class="hidden md:flex ml-10 space-x-8">
                    <a href="{{ $baseUrl }}:{{ $blogPort }}/blogs" class="text-gray-700 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">Blogs</a>
                    
                    @auth
                        @php
                            $user = Auth::user();
                            $roles = \Illuminate\Support\Facades\DB::table('role_user')
                                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                                ->where('role_user.user_id', $user->id)
                                ->pluck('roles.name')
                                ->toArray();
                        @endphp
                        
                        @if(in_array('vendor', $roles))
                            <a href="{{ $baseUrl }}:{{ $vendorPort }}/vendor/dashboard" class="text-gray-700 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">Store Dashboard</a>
                        @endif
                        
                        @if(in_array('admin', $roles))
                            <a href="{{ $baseUrl }}:{{ $authPort }}/admin/panel" class="text-gray-700 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">Admin Dashboard</a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side Auth Links -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ $baseUrl }}:{{ $authPort }}/login" class="text-gray-600 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">Log in</a>
                    <a href="{{ $baseUrl }}:{{ $authPort }}/register" class="px-5 py-2 rounded-full font-medium text-sm text-white bg-indigo-600 shadow-sm hover:shadow-md hover:bg-indigo-700 transition-all duration-200">Register</a>
                @endguest
                
                @auth
                    <div class="flex items-center space-x-4">
                        <a href="{{ $baseUrl }}:{{ $authPort }}/profile" class="text-gray-600 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">Profile</a>
                        <form method="POST" action="{{ $baseUrl }}:{{ $authPort }}/logout" class="inline">
                            @csrf
                            <button type="submit" class="px-5 py-2 rounded-full font-medium text-sm text-indigo-600 bg-white border border-indigo-100 shadow-sm hover:shadow-md hover:bg-indigo-50 transition-all duration-200">Log Out</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
