<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <div class="mb-8 border-b pb-4">
                    <h1 class="text-2xl font-bold text-gray-900">Apply for a Vendor Account</h1>
                    <p class="text-sm text-gray-600 mt-1">Submit your storefront information to unlock the vendor dashboard and publishing tools.</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if($application && $application->status === 'revision_required')
                    <div class="mb-8 p-5 bg-amber-50 border-l-4 border-amber-500 rounded shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                ⚠️
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-semibold text-amber-800">Action Required: Revision Needed</h3>
                                <div class="mt-2 text-sm text-amber-700">
                                    <p class="italic">"{{ $application->admin_notes }}"</p>
                                </div>
                                <p class="mt-3 text-xs text-amber-600 font-medium">Please correct the flagged data points and resubmit your portfolio for review.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('vendor.apply.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div style="display: none;">
                        <input type="text" name="honeypot_check_field" value="">
                    </div>

                    <div>
                        <label for="shop_name" class="block text-sm font-medium text-gray-700">Proposed Shop/Business Name</label>
                        <input type="text" name="shop_name" id="shop_name" 
                               value="{{ old('shop_name', $application->shop_name ?? '') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                               placeholder="e.g., Central History Museum Cafe" required>
                    </div>

                    <div>
                        <label for="physical_address" class="block text-sm font-medium text-gray-700">Physical Storefront Address</label>
                        <textarea name="physical_address" id="physical_address" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                  placeholder="Provide full storefront location coordinates or street details..." required>{{ old('physical_address', $application->physical_address ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="business_license_number" class="block text-sm font-medium text-gray-700">Business Registration / License Number</label>
                        <input type="text" name="business_license_number" id="business_license_number" 
                               value="{{ old('business_license_number', $application->business_license_number ?? '') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                               placeholder="e.g., REG-99201-XYZ" required>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            {{ $application && $application->status === 'revision_required' ? 'Resubmit Amended Application' : 'Submit Application' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>