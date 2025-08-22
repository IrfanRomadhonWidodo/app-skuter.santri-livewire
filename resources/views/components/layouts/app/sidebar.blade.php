<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <div class="flex justify-center items-center h-full w-full">
                <img
                    src="/image/logo-santri-unu-purwokerto.png"
                    alt="Logo Santri UNU Purwokerto"
                    class="max-w-[150px] max-h-[50px] w-auto h-auto object-contain"
                />
            </div>
        </a>


<flux:navlist variant="outline">
    {{-- Dashboard --}}
    <flux:navlist.group :heading="__('Home')" class="grid">
        <flux:navlist.item 
            icon="house" 
            :href="route('dashboard')" 
            :current="request()->routeIs('dashboard')" 
            wire:navigate
            class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 text-white rounded-lg">
            {{ __('Dashboard') }}
        </flux:navlist.item>
    </flux:navlist.group>

    @if(auth()->user()->role === 'admin')
    <flux:navlist.group :heading="__('Keuangan')" class="grid">

        {{-- Menu Transaksi dengan dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="w-full text-left">
                <flux:navlist.item 
                    icon="folder-git-2" 
                    href="javascript:void(0)"
                    class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 text-white rounded-lg">
                    {{ __('Transaksi') }}
                </flux:navlist.item>
            </button>

            <div x-show="open" x-transition
                 class="ml-6 mt-1 flex flex-col rounded-lg shadow-lg">
                <flux:navlist.item 
                    icon="book-open-text" 
                    :href="route('admin.transaksi.pembayaran-tagihan')" 
                    :current="request()->routeIs('admin.transaksi.pembayaran-tagihan')" 
                    class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 
                        data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 
                        text-white rounded-lg">
                    {{ __('Pembayaran Tagihan') }}
                </flux:navlist.item>
                <flux:navlist.item icon="layout-grid" href="#"
                    class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 text-white rounded-lg">
                    {{ __('Tagihan SPP') }}
                </flux:navlist.item>
                <flux:navlist.item icon="chevrons-up-down" href="#"
                    class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 text-white rounded-lg">
                    {{ __('Riwayat Pembayaran') }}
                </flux:navlist.item>
            </div>
        </div>

        {{-- Menu Administrasi dengan dropdown --}}
        <div x-data="{ open: false }" class="relative mt-1">
            <button @click="open = !open" class="w-full text-left">
                <flux:navlist.item 
                    icon="settings" 
                    href="javascript:void(0)"
                    class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 text-white rounded-lg">
                    {{ __('Administrasi') }}
                </flux:navlist.item>
            </button>

            <div x-show="open" x-transition
                 class="ml-6 mt-1 flex flex-col rounded-lg shadow-lg">
                <flux:navlist.item icon="credit-card" href="#"
                    class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 text-white rounded-lg">
                    {{ __('Penangguhan Bayar') }}
                </flux:navlist.item>
                <flux:navlist.item icon="credit-card" href="#"
                    class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 text-white rounded-lg">
                    {{ __('Kelola SPP Prodi') }}
                </flux:navlist.item>
            </div>
        </div>

        {{-- Menu Laporan sejajar --}}
        <flux:navlist.item icon="file-text" href="#"
            class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 text-white rounded-lg">
            {{ __('Laporan') }}
        </flux:navlist.item>

        {{-- Menu Kelola User sejajar --}}
        
<flux:navlist.item 
    icon="users" 
    :href="route('admin.users')"
    :current="request()->routeIs('admin.users')"
    class="hover:bg-gradient-to-r hover:from-green-900 hover:to-green-700 
           data-[current]:bg-gradient-to-r data-[current]:from-green-900 data-[current]:to-green-700 
           text-white rounded-lg">
    {{ __('Kelola User') }}
</flux:navlist.item>


    </flux:navlist.group>
    @endif
</flux:navlist>


            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
