<x-guest-layout>
    <div class="mb-4">
        <a href="/" class="text-sm text-forest-600 hover:text-forest-900 flex items-center">
            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Masuk untuk mengelola data kehutanan dan mengajukan laporan penggunaan lahan.') }}
    </div>

    <!-- Session Status -->
    <div class="mb-4 text-sm font-medium text-green-600">
        <!-- Status placeholder -->
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email"
                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-forest-500 focus:ring focus:ring-forest-500 focus:ring-opacity-50 p-2 border"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <div class="mt-2 text-sm text-red-600"><!-- Error placeholder --></div>
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ show: false }">
            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>

            <div class="relative">
                <input id="password"
                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-forest-500 focus:ring focus:ring-forest-500 focus:ring-opacity-50 p-2 border pr-10"
                    :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" />
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-forest-600 shadow-sm focus:border-forest-300 focus:ring focus:ring-forest-200 focus:ring-opacity-50"
                    name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest-500 mr-4"
                href="{{ route('register') }}">
                {{ __('Belum punya akun? Daftar') }}
            </a>
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest-500"
                href="{{ route('password.request') }}">
                {{ __('Lupa Password?') }}
            </a>

            <button
                class="ml-3 inline-flex items-center px-4 py-2 bg-forest-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-forest-700 focus:bg-forest-700 active:bg-forest-900 focus:outline-none focus:ring-2 focus:ring-forest-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>