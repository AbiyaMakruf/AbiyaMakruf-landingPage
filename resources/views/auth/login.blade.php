<x-app-layout>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-900 via-slate-800 to-slate-900 -mb-12 px-4">
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden rounded-2xl border border-white/20">
            <div class="mb-8 text-center">
                <div class="mx-auto h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Admin Access</h2>
                <p class="text-sm text-gray-500 mt-2">Please sign in to your dashboard.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block font-semibold text-sm text-gray-700">Email Address</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input id="email" class="block w-full pl-10 rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-opacity-50 p-3 transition duration-150 ease-in-out" type="email" name="email" :value="old('email')" required autofocus placeholder="admin@example.com" />
                    </div>
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-6">
                    <label for="password" class="block font-semibold text-sm text-gray-700">Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" class="block w-full pl-10 rounded-lg border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-opacity-50 p-3 transition duration-150 ease-in-out" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg transform hover:-translate-y-0.5">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
