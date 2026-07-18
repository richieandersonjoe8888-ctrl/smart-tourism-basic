<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <h1 class="text-3xl font-bold text-gray-900 border-b pb-4">{{ __('Central Administrative Console') }}</h1>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Pending Vendor Applications') }}</h2>
                @if ($vendorRequests->isEmpty())
                    <p class="text-gray-500 text-sm">{{ __('No pending vendor applications at this time.') }}</p>
                @else
                    <div class="divide-y">
                        @foreach ($vendorRequests as $applicant)
                            <div class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $applicant->user->email }}</p>
                                    <p class="text-xs text-gray-500">{{ __('Origin:') }}
                                        {{ $applicant->user->city_of_origin ?? __('Unknown') }}</p>
                                </div>
                                <form action="{{ route('admin.application.handle', $applicant) }}" method="POST"
                                    class="space-x-2">
                                    @csrf
                                    <button name="action" value="approve"
                                        class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">{{ __('Approve') }}</button>
                                    <button name="action" value="reject"
                                        class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">{{ __('Reject') }}</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Blog Approval Queue') }}</h2>
                    @foreach ($pendingBlogs as $blog)
                        <div class="border p-3 rounded mb-3 bg-gray-50">
                            <h3 class="font-bold text-gray-900 hover:text-indigo-655 transition">
                                <a href="{{ config('services.blog_service.url') }}/blogs/{{ $blog->id }}" target="_blank">
                                    {{ $blog->title }} {!! __('View &rarr;') !!}
                                </a>
                            </h3>
                            @if ($blog->image)
                                <div class="mb-4">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">{{ __('Article Banner') }}</span>
                                    <img src="{{ config('services.blog_service.url') }}/storage/{{ $blog->image }}"
                                        class="w-full max-h-48 object-cover rounded-md border shadow-sm"
                                        alt="Blog submission cover banner preview">
                                </div>
                            @endif
                            <p class="text-xs text-gray-600 my-2">{{ Str::limit($blog->content, 100) }}</p>
                            
                            <form action="{{ route('admin.blogs.handle', $blog) }}" method="POST" class="mt-3 flex gap-2">
                                @csrf
                                <button name="action" value="approve"
                                    class="bg-green-600 text-white px-3 py-1.5 rounded text-xs font-semibold hover:bg-green-700 transition">{{ __('Approve') }}</button>
                                <button name="action" value="reject"
                                    class="bg-red-600 text-white px-3 py-1.5 rounded text-xs font-semibold hover:bg-red-700 transition">{{ __('Reject') }}</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Active Publications (Takedown Guard)') }}</h2>
                    @foreach ($activeBlogs as $blog)
                        <div class="border p-3 rounded mb-3 bg-gray-50 space-y-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-gray-900 hover:text-indigo-655 transition">
                                        <a href="{{ config('services.blog_service.url') }}/blogs/{{ $blog->id }}" target="_blank">
                                            {{ $blog->title }} {!! __('View &rarr;') !!}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-gray-500">{{ __('Author ID:') }} {{ $blog->user_id }}</p>
                                </div>
                            </div>
                            <!-- Form for disable with reason -->
                            <form action="{{ route('admin.blogs.disable', $blog) }}" method="POST" class="mt-2 flex gap-2">
                                @csrf
                                <input type="text" name="moderation_reason" placeholder="{{ __('Reason for takedown...') }}" required
                                    class="text-xs rounded border-gray-300 w-full px-2 py-1 focus:ring-red-500 focus:border-red-500">
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-red-700 transition whitespace-nowrap">
                                    {{ __('Disable') }}
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ __('Direct Vendor Communication Channels') }}</h2>
                    <form method="GET" class="flex gap-2">
                        <select name="tag" class="text-xs rounded border-gray-300">
                            <option value="">{{ __('All Tags') }}</option>
                            <option value="Premium">{{ __('Premium') }}</option>
                            <option value="Verified">{{ __('Verified') }}</option>
                        </select>
                        <button class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">{{ __('Filter') }}</button>
                    </form>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
                            <th class="p-3">{{ __('Vendor Email') }}</th>
                            <th class="p-3">{{ __('Account Status') }}</th>
                            <th class="p-3">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        @foreach ($communicableVendors as $vendor)
                            <tr>
                                <td class="p-3 font-medium text-gray-900">{{ $vendor->email }}</td>
                                <td class="p-3">
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full {{ $vendor->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ __($vendor->status) }}
                                    </span>
                                </td>
                                <td class="p-3 space-x-3">
                                    <form action="{{ route('admin.user.ban', $vendor) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button class="text-xs text-red-600 hover:underline">
                                            {{ $vendor->status === 'frozen' ? __('Unban User') : __('Ban & Revoke Rights') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Global Business Tag Management') }}</h2>

                <form action="{{ route('admin.tags.store') }}" method="POST" class="flex gap-3 mb-6 max-w-md">
                    @csrf
                    <input type="text" name="name" placeholder="{{ __('e.g., historical, adventure, cafe') }}"
                        class="text-sm rounded border-gray-300 w-full" required>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700 whitespace-nowrap">{{ __('Add Tag') }}</button>
                </form>

                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ __('Active Categories') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($allTags as $tag)
                        <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full border">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
