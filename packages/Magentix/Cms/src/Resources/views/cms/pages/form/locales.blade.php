@php
    $currentLocale = core()->getRequestedLocale();
@endphp

<div class="flex  gap-4 justify-between items-center mt-2 max-md:flex-wrap">
    <div class="flex gap-x-1 items-center">
        <!-- Locale Switcher -->
        @php $allActiveLocales = core()->getAllActiveLocales(); @endphp

        <x-admin::dropdown :class="$allActiveLocales->count() <= 1 ? 'hidden' : ''">
            <!-- Dropdown Toggler -->
            <x-slot:toggle>
                <button
                    type="button"
                    class="flex gap-x-1 items-center px-3 py-1.5 border-2 border-transparent rounded-md font-semibold whitespace-nowrap cursor-pointer marker:shadow appearance-none transition-all hover:!bg-violet-50 dark:hover:!bg-cherry-900 text-gray-600 dark:!text-slate-50"
                >
                    <span class="icon-language text-2xl"></span>

                    {{ $currentLocale->name }}

                    <span class="icon-chevron-down text-2xl"></span>
                </button>
            </x-slot>

            <!-- Dropdown Content -->
            <x-slot:content class="!p-0">
                @foreach ($allActiveLocales as $locale)
                    <a
                        href="?{{ Arr::query(['locale' => $locale->code]) }}"
                        class="flex gap-2.5 px-5 py-2 text-base cursor-pointer hover:bg-violet-50 dark:hover:bg-cherry-800 dark:text-white {{ $locale->code == $currentLocale->code ? 'bg-gray-100 dark:bg-cherry-800' : ''}}"
                    >
                        {{ $locale->name }}
                    </a>
                @endforeach
            </x-slot>
        </x-admin::dropdown>
    </div>
</div>
