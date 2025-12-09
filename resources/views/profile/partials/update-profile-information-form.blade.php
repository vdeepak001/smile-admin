<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Avatar Upload --}}
        <div>
            <x-input-label for="avatar" :value="__('Profile Picture')" />
            <div class="mt-2 flex items-center gap-4">
                @if($user->avatar)
                    <img src="{{ $user->getAvatarUrl() }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover">
                @else
                    <div class="w-20 h-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                        <span class="text-2xl text-gray-500 dark:text-gray-400">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
                <div class="flex-1">
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100
                        dark:file:bg-gray-700 dark:file:text-gray-300
                        dark:hover:file:bg-gray-600">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, GIF up to 2MB</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- First Name --}}
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" autocomplete="given-name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        {{-- Last Name --}}
        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" autocomplete="family-name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        {{-- Phone Number --}}
        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Role Display (Read-only) --}}
        <div>
            <x-input-label for="role" :value="__('Role')" />
            <div class="mt-1 px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-md text-gray-700 dark:text-gray-300">
                {{ ucfirst($user->role) }}
            </div>
        </div>

        {{-- Admin Only Fields --}}
        @if($user->canUpdateRights())
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Administrative Settings') }}
                </h3>

                {{-- Active Status --}}
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="active_status" name="active_status" value="1" 
                        {{ old('active_status', $user->active_status) ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="active_status" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        {{ __('Active Status') }}
                    </label>
                </div>

                {{-- College Rights --}}
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="college_rights" name="college_rights" value="1" 
                        {{ old('college_rights', $user->college_rights) ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="college_rights" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        {{ __('College Rights') }}
                    </label>
                </div>

                {{-- Course Rights --}}
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="course_rights" name="course_rights" value="1" 
                        {{ old('course_rights', $user->course_rights) ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="course_rights" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        {{ __('Course Rights') }}
                    </label>
                </div>

                {{-- Students Rights --}}
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="students_rights" name="students_rights" value="1" 
                        {{ old('students_rights', $user->students_rights) ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="students_rights" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        {{ __('Students Rights') }}
                    </label>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
