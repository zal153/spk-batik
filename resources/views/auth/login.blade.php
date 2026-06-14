<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-wide">Login</h2>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <x-text-input id="email"
                class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <div class="relative mt-1">
                <x-text-input id="password"
                    class="block w-full rounded-xl border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm pr-10"
                    type="password" name="password" required autocomplete="current-password" />
                <!-- Password visibility toggle button -->
                <button type="button" onclick="togglePasswordVisibility()"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <!-- Eye Open Icon by default -->
                        <path id="eye-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Ingat Saya</span>
            </label>
        </div>

        <!-- Submit Button Centered -->
        <div class="flex flex-col items-center gap-4 pt-2">
            <button type="submit"
                class="w-full inline-flex justify-center items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold text-sm rounded-xl shadow-lg transition duration-150 uppercase tracking-wide">
                {{ __('Login') }}
            </button>

            <div class="flex flex-col items-center gap-1.5 mt-2">
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif

                @if (Route::has('register'))
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Belum punya akun?
                        <a class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold"
                            href="{{ route('register') }}">
                            Daftar disini
                        </a>
                    </span>
                @endif
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
                eyePath.setAttribute("d",
                    "M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"
                    );
            } else {
                passwordField.type = "password";
                // Eye open path
                eyePath.setAttribute("d",
                    "M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                    );
            }
        }
    </script>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                @if (session('login_attempts') == 5)
                    Swal.fire({
                        title: 'Bantuan Login',
                        text: '{{ $errors->first() }} Anda sudah salah memasukkan password sebanyak 5 kali. Apakah Anda ingin menyetel ulang kata sandi?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Lupa Password',
                        cancelButtonText: 'Coba Lagi',
                        confirmButtonColor: '#4f46e5',
                        cancelButtonColor: '#6b7280',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('password.request') }}";
                        }
                    });
                @else
                    Swal.fire({
                        title: 'Login Gagal',
                        text: '{{ $errors->first() }}',
                        icon: 'error',
                        confirmButtonText: 'Coba Lagi',
                        confirmButtonColor: '#4f46e5',
                    });
                @endif
            });
        </script>
    @endif
</x-guest-layout>
