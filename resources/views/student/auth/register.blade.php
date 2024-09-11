<x-guest-layout>
    <form method="POST" action="{{ route('student.register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-cente mt-4">
            <x-primary-button class="w-full flex justify-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        <div class="flex items-center justify-center mt-4">
            <span class="text-gray-600 dark:text-gray-400">Have an account?</span>
            <a class="ml-1 underline text-sm text-indigo-600 dark:text-indigo-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Log in?') }}
            </a>
        </div>
        </div>
    </form>
</x-guest-layout>
