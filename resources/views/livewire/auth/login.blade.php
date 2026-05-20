<div class="flex flex-col gap-6">
    <div class="flex w-full flex-col text-center">
        <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">
            {{ __("Log in to your account") }}
        </h1>
        <h3 class="text-zinc-600 dark:text-white">
            {{ __("Enter your email and password below to log in") }}
        </h3>
    </div>

    <!-- Session Status -->
    <x-cube::auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        {{-- Email Address --}}
        <x-cube::group name="email" label="Email Address" required>
            <x-cube::input class="w-full" type="email" wire:model="email" required />
        </x-cube::group>

        {{-- Password --}}
        <x-cube::group name="password" label="Password" required>
            <x-cube::input class="w-full" type="password" wire:model="password" required />
        </x-cube::group>

        <div class="flex items-center justify-between">
            <!-- Remember Me -->
            <x-cube::checkbox wire:model="remember">{{ __('Remember me') }}</x-cube::checkbox>

            @if (Route::has("password.request"))
                <x-cube::link class="text-sm text-zinc-700 dark:text-white dark:hover:text-white" :href="route('password.request')" wire:navigate>
                    {{ __("Forgot your password?") }}
                </x-cube::link>
            @endif
        </div>

        <div class="flex items-center justify-end">
            <x-cube::button class="w-full" variant="primary" type="submit">
                {{ __("Log in") }}
            </x-cube::button>
        </div>
    </form>

    @if (Route::has("register"))
        <div class="space-x-1 text-center text-sm tracking-widest text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <x-cube::link :href="route('register')" wire:navigate>{{ __("Sign up") }}</x-cube::link>
        </div>
    @endif
</div>
