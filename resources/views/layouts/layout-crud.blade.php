<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($nome) }}
        </h2>
    </x-slot>
    <!-- Page Content -->
    <main>
        @yield('create')

        @yield('edit')
    </main>

</x-app-layout>