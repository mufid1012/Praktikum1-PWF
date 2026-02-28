<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('About Me') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <h3 class="text-lg font-bold mb-4">Biodata</h3>

                    <p><strong>Nama:</strong> Mufid Ghibran</p>
                    <p><strong>NIM:</strong> 2023xxxx</p>
                    <p><strong>Program Studi:</strong> Informatika</p>
                    <p><strong>Hobi:</strong> Lari, Coding, Trail Running</p>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>