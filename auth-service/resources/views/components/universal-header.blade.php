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
                    <img src="{{ asset('images/app_icon.png') }}" class="w-10 h-10 object-contain" alt="SmartTourism Logo">
                    <span class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">SmartTourism</span>
                </a>
                
                <!-- Main Links -->
                <div class="hidden md:flex ml-10 space-x-8">
                    <a href="{{ $baseUrl }}:{{ $blogPort }}/blogs" class="text-gray-700 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">{{ __('Blogs') }}</a>
                    
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
                            <a href="{{ $baseUrl }}:{{ $vendorPort }}/vendor/dashboard" class="text-gray-700 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">{{ __('Store Dashboard') }}</a>
                        @endif
                        
                        @if(in_array('admin', $roles))
                            <a href="{{ $baseUrl }}:{{ $authPort }}/admin/panel" class="text-gray-700 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">{{ __('Admin Dashboard') }}</a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side Auth Links & Lang Switcher -->
            <div class="flex items-center space-x-4">
                <!-- Language Switcher -->
                <div class="relative inline-block text-left mr-2">
                    <select onchange="const url = new URL(window.location.href); url.searchParams.set('lang', this.value); window.location.href = url.href; window.location.reload();" class="bg-white/70 backdrop-blur-sm border border-gray-200 rounded-md text-xs font-semibold text-gray-700 py-1 pl-2 pr-6 focus:outline-none focus:ring-1 focus:ring-indigo-500 cursor-pointer transition-all w-auto appearance-none" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 20 20\' fill=\'%234a5568\'%3E%3Cpath fill-rule=\'evenodd\' d=\'M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z\' clip-rule=\'evenodd\'/%3E%3C/svg%3E'); background-position: right 0.4rem center; background-repeat: no-repeat; background-size: 0.9em;">
                        <option value="en" {{ App::getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                        <option value="id" {{ App::getLocale() === 'id' ? 'selected' : '' }}>ID</option>
                    </select>
                </div>

                @guest
                    <a href="{{ $baseUrl }}:{{ $authPort }}/login" class="text-gray-600 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">{{ __('Log in') }}</a>
                    <a href="{{ $baseUrl }}:{{ $authPort }}/register" class="px-5 py-2 rounded-full font-medium text-sm text-white bg-indigo-600 shadow-sm hover:shadow-md hover:bg-indigo-700 transition-all duration-200">{{ __('Register') }}</a>
                @endguest
                
                @auth
                    <div class="flex items-center space-x-4">
                        <a href="{{ $baseUrl }}:{{ $authPort }}/profile" class="text-gray-600 hover:text-indigo-600 font-medium px-3 py-2 transition-colors">{{ __('Profile') }}</a>
                        <form method="POST" action="{{ $baseUrl }}:{{ $authPort }}/logout" class="inline">
                            @csrf
                            <button type="submit" class="px-5 py-2 rounded-full font-medium text-sm text-indigo-600 bg-white border border-indigo-100 shadow-sm hover:shadow-md hover:bg-indigo-50 transition-all duration-200">{{ __('Log Out') }}</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
