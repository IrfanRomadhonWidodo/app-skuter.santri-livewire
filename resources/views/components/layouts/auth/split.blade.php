<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white antialiased dark:bg-neutral-950">
    <div class="relative grid h-screen lg:grid-cols-2">
        
        {{-- Bagian Kiri: Background + Overlay --}}
        <div class="relative hidden lg:flex">
            <img src="{{ asset('image/login_template.png') }}" 
                alt="Login Template" 
                class="absolute inset-0 h-full w-full object-cover" />
            
            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-br from-green-700/90 via-green-800/90 to-green-900/90"></div>
        </div>


        {{-- Bagian Kanan: Form --}}
        <div class="flex w-full items-center justify-center p-6">
            <div class="w-full max-w-sm space-y-6">

                
                {{-- Logo --}}
                <div class="flex justify-center">
                    <img src="{{ asset('image/logo-santri-unu-purwokerto.png') }}" 
                         alt="Santri UNU Purwokerto" 
                         class="h-16 w-auto" />
                </div>

                {{-- Slot Form Livewire --}}
                    {{ $slot }}

            </div>
        </div>

    </div>
    @fluxScripts
</body>
</html>
