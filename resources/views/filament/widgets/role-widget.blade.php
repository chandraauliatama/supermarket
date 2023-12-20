<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-2 text-xl font-bold">
            <p>Jenis Akses Akun: {{ \App\Enums\Role::roleString(auth()->user()->role) }}</p>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
