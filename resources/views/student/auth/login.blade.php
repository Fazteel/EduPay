<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-center text-xl font-bold mb-3 text-white">Student Login</h2>
    <form method="POST" action="{{ route('student.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <div class="flex justify-end items-center mt-2">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="flex items-cente mt-4">
            <x-primary-button class="w-full flex justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="flex justify-center mt-2">
            <span class="text-gray-600 dark:text-gray-400">Don't have an account? </span>
            <a class="ml-1 underline text-sm text-indigo-600 dark:text-indigo-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                {{ __('Sign Up') }}
            </a>
        </div>
    </form>
</x-guest-layout>
