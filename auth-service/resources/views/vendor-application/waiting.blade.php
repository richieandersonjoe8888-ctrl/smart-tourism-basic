<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center space-y-6">
                
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 text-blue-600 text-3xl animate-pulse">
                    ⏳
                </div>

                <div class="space-y-2">
                    <h1 class="text-xl font-bold text-gray-900">Application Under Review</h1>
                    <p class="text-sm text-gray-600">We have received your storefront credentials and business profiles.</p>
                </div>

                <div class="bg-gray-50 p-4 rounded text-xs text-gray-500 text-left space-y-2 border">
                    <p class="font-semibold text-gray-700">What happens next?</p>
                    <p>1. Our administrative team will verify your provided business registration licenses.</p>
                    <p>2. An administrator will coordinate an external virtual identity verification verification session with you.</p>
                    <p>3. Upon verification clearance, your platform capabilities will elevate automatically.</p>
                </div>

                <div>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                        Return to Main Profile &rarr;
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>