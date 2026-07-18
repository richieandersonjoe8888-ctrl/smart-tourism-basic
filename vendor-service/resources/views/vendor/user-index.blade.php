@extends('layouts.app')
@section('content')
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            
            <div class="text-xs text-gray-500">
                <a href="{{ route('vendor.dashboard') }}" class="hover:underline">{{ __('Dashboard') }}</a> &rarr; <span class="text-gray-700 font-semibold">{{ __('User Directory') }}</span>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg border p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('Global Customer Registry') }}</h1>
                    <p class="text-sm text-gray-600">{{ __('Administrative operational read-access to complete system accounts profiles.') }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <th class="p-3">{{ __('User ID') }}</th>
                                <th class="p-3">{{ __('Account Email') }}</th>
                                <th class="p-3">{{ __('Account State') }}</th>
                                <th class="p-3">{{ __('System Permissions (Roles)') }}</th>
                                <th class="p-3">{{ __('Creation Date') }}</th>
                                <th class="p-3 text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach($users as $registeredUser)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-3 font-mono text-xs text-gray-400">#{{ $registeredUser->id }}</td>
                                    <td class="p-3 font-medium text-gray-900">{{ $registeredUser->email }}</td>
                                    <td class="p-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $registeredUser->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($registeredUser->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="flex gap-1">
                                            @foreach($registeredUser->roles as $role)
                                                <span class="bg-indigo-50 text-indigo-700 text-xs px-2 py-0.5 rounded font-medium border border-indigo-100">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-3 text-xs text-gray-500">
                                        {{ $registeredUser->created_at ? $registeredUser->created_at->format('M d, Y') : 'Pre-seeded' }}
                                    </td>
                                    <td class="p-3 text-right">
                                        <a href="{{ route('vendor.users.show', $registeredUser->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded transition-colors">
                                            {{ __('View Profile') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 border-t pt-4">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection