<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-wide">Register</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm pr-10"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <!-- Password visibility toggle button -->
                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <!-- Eye Open Icon by default -->
                        <path id="eye-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <x-text-input id="password_confirmation" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm pr-10"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <!-- Confirm Password visibility toggle button -->
                <button type="button" onclick="toggleConfirmPasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg id="confirm-eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path id="confirm-eye-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button Centered -->
        <div class="flex flex-col items-center gap-4 pt-2">
            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold text-sm rounded-xl shadow-lg transition duration-150 uppercase tracking-wide">
                {{ __('Register') }}
            </button>

            <div class="flex flex-col items-center gap-1.5 mt-2">
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    Sudah punya akun? 
                    <a class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold" href="{{ route('login') }}">
                        Login disini
                    </a>
                </span>
            </div>
        </div>
    </form>

    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var eyePath = document.getElementById("eye-path");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                // Eye slash path
                eyePath.setAttribute("d", "M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18");
            } else {
                passwordField.type = "password";
                // Eye open path
                eyePath.setAttribute("d", "M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z");
            }
        }

        function toggleConfirmPasswordVisibility() {
            var passwordField = document.getElementById("password_confirmation");
            var eyePath = document.getElementById("confirm-eye-path");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                // Eye slash path
                eyePath.setAttribute("d", "M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18");
            } else {
                passwordField.type = "password";
                // Eye open path
                eyePath.setAttribute("d", "M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z");
            }
        }
    </script>
</x-guest-layout>
