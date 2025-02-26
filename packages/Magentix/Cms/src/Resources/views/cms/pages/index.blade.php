<x-admin::layouts>
    <x-slot:title>
        @lang('cms::app.cms.pages.index.title')
    </x-slot>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-slate-50 font-bold">
            @lang('cms::app.cms.pages.index.title')
        </p>

        <div class="flex gap-x-2.5 items-center">
            @if (bouncer()->hasPermission('cms.pages.create'))
                <a href="{{ route('admin.cms.pages.create') }}">
                    <div class="primary-button">
                        @lang('cms::app.cms.pages.index.add')
                    </div>
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('unopim.admin.cms.pages.list.before') !!}

    <x-admin::datagrid src="{{ route('admin.cms.pages.index') }}" />

    {!! view_render_event('unopim.admin.cms.pages.list.after') !!}

</x-admin::layouts>
