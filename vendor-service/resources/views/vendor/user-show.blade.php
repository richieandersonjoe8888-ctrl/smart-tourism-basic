@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            
            <!-- Breadcrumbs -->
            <div class="text-xs text-gray-500">
                <a href="{{ route('vendor.dashboard') }}" class="hover:underline">{{ __('Dashboard') }}</a> &rarr; 
                <a href="{{ route('vendor.users.index') }}" class="hover:underline">{{ __('User Directory') }}</a> &rarr; 
                <span class="text-gray-700 font-semibold">{{ $user->name }}</span>
            </div>

            <!-- Profile Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border p-8">
                
                <!-- Card Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 border-b border-gray-200">
                    <div class="flex items-center space-x-4 mb-4 md:mb-0">
                        <!-- Avatar placeholder with initials -->
                        <div class="h-16 w-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold shadow-md shadow-indigo-150">
                            {{ strtoupper(substr($user->name, 0, 1)) }}{{ strlen($user->name) > 1 ? strtoupper(substr($user->name, strpos($user->name, ' ') + 1, 1)) : '' }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst(__($user->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Profile Details Grid -->
                <div class="pt-6 space-y-6">
                    <div>
                        <h2 class="text-sm font-semibold uppercase text-gray-400 tracking-wider mb-4">{{ __('Profile Details') }}</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg border border-gray-100">
                            
                            <div>
                                <span class="block text-xs font-medium text-gray-400 uppercase">{{ __('Age') }}</span>
                                <span class="text-sm font-semibold text-gray-800 mt-1 block">
                                    {{ $user->age ?? __('Not Provided') }}
                                </span>
                            </div>

                            <div>
                                <span class="block text-xs font-medium text-gray-400 uppercase">{{ __('Gender') }}</span>
                                <span class="text-sm font-semibold text-gray-800 mt-1 block">
                                    {{ $user->gender ? __($user->gender) : __('Not Provided') }}
                                </span>
                            </div>

                            <div>
                                <span class="block text-xs font-medium text-gray-400 uppercase">{{ __('Country of Origin') }}</span>
                                <span class="text-sm font-semibold text-gray-800 mt-1 block">
                                    {{ $user->country_of_origin ?? __('Not Provided') }}
                                </span>
                            </div>

                            <div>
                                <span class="block text-xs font-medium text-gray-400 uppercase">{{ __('City of Origin') }}</span>
                                <span class="text-sm font-semibold text-gray-800 mt-1 block">
                                    {{ $user->city_of_origin ?? __('Not Provided') }}
                                </span>
                            </div>

                        </div>
                    </div>

                    <!-- Account System Metadata -->
                    <div>
                        <h2 class="text-sm font-semibold uppercase text-gray-400 tracking-wider mb-4">{{ __('Account Meta') }}</h2>
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                            
                            <div>
                                <span class="block text-xs font-medium text-gray-400 uppercase">{{ __('System Permissions (Roles)') }}</span>
                                <div class="flex flex-wrap gap-1.5 mt-1.5">
                                    @forelse($user->roles as $role)
                                        <span class="bg-indigo-50 text-indigo-700 text-xs px-2.5 py-1 rounded font-semibold border border-indigo-100">
                                            {{ __($role->name) }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 text-xs italic">{{ __('No Roles Assigned') }}</span>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Footer Back Navigation -->
                <div class="mt-8 border-t border-gray-200 pt-6 flex justify-end">
                    <a href="{{ route('vendor.users.index') }}" class="text-xs text-indigo-600 hover:text-indigo-900 font-semibold bg-indigo-50 hover:bg-indigo-100 px-4 py-2 rounded transition-colors">
                        &larr; {{ __('Back to User Directory') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
