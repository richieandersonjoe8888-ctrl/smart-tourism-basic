@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between items-center border-b pb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Vendor Management Portal</h1>
                    <p class="text-sm text-gray-600">Configure your storefront visibility and submit verified publications.
                    </p>
                </div>
                <a href="{{ route('vendor.users.index') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-medium shadow-sm">
                    View Complete User Directory &rarr;
                </a>
            </div>

            @if (session('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded text-sm text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm space-y-6 border">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">🏪 Core Storefront Configuration</h2>

                    <form action="{{ route('vendor.profile.update') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Business
                                Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Tell travelers what makes your location extraordinary..." required>{{ old('description', $profile->description ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="opening_time" class="block text-sm font-medium text-gray-700">Opening
                                    Hours</label>
                                <input type="time" name="opening_time" id="opening_time"
                                    value="{{ old('opening_time', $profile && $profile->opening_time ? \Carbon\Carbon::parse($profile->opening_time)->format('H:i') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>
                            <div>
                                <label for="closing_time" class="block text-sm font-medium text-gray-700">Closing
                                    Hours</label>
                                <input type="time" name="closing_time" id="closing_time"
                                    value="{{ old('closing_time', $profile && $profile->closing_time ? \Carbon\Carbon::parse($profile->closing_time)->format('H:i') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Business Tags /
                                Categories</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-gray-50 p-4 rounded-md border">
                                @foreach ($allTags as $tag)
                                    <label class="inline-flex items-center text-sm text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                            {{ $profile && $profile->tags->contains($tag->id) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                                        {{ ucwords($tag->name) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end border-t pt-4">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded shadow-sm">
                                Save Profile Configurations
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border h-fit space-y-4">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">✍️ Publish New Blog</h2>
                    <p class="text-xs text-gray-500">Draft articles are sent straight to the admin pipeline for moderation
                        and approval before public distribution.</p>

                    <form action="{{ route('vendor.blog.store') }}" method="POST" class="space-y-4 pt-2">
                        @csrf
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Article Title</label>
                            <input type="text" name="title" id="title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="e.g., Top 5 Hidden Exhibits This Week" required>
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Content / Article
                                Body</label>
                            <textarea name="content" id="content" rows="6"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Write your content narrative here..." required></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded text-sm shadow-sm transition">
                            Submit to Admin Queue
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
