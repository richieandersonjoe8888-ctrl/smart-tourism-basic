<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-100">
            <div>
                <x-input-label for="age" :value="__('Age (Optional)')" />
                <x-text-input id="age" name="age" type="number" class="mt-1 block w-full" :value="old('age', $user->age)" />
                <x-input-error class="mt-2" :messages="$errors->get('age')" />
            </div>

            <div>
                <x-input-label for="gender" :value="__('Gender (Optional)')" />
                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select Gender...</option>
                    <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                    @if(!in_array(old('gender', $user->gender), ['Male', 'Female', null, '']))
                        <option value="{{ old('gender', $user->gender) }}" selected>{{ ucfirst(old('gender', $user->gender)) }} (Current)</option>
                    @endif
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>

            <div>
                <x-input-label for="country_of_origin" :value="__('Country of Origin (Optional)')" />
                <x-text-input id="country_of_origin" name="country_of_origin" type="text" class="mt-1 block w-full" :value="old('country_of_origin', $user->country_of_origin)" />
                <x-input-error class="mt-2" :messages="$errors->get('country_of_origin')" />
            </div>

            <div>
                <x-input-label for="city_of_origin" :value="__('City of Origin (Optional)')" />
                <x-text-input id="city_of_origin" name="city_of_origin" type="text" class="mt-1 block w-full" :value="old('city_of_origin', $user->city_of_origin)" />
                <x-input-error class="mt-2" :messages="$errors->get('city_of_origin')" />
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
