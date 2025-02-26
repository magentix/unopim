<div class="flex justify-between items-center">
    <p class="text-xl text-gray-800 dark:text-slate-50 font-bold">
        @lang('cms::app.cms.pages.form.header.title')
    </p>

    <div class="flex gap-x-2.5 items-center">
        <a href="{{ route('admin.cms.pages.index') }}" class="transparent-button">
            @lang('cms::app.cms.pages.form.header.back-btn')
        </a>

        <button type="submit" class="primary-button">
            @lang('cms::app.cms.pages.form.header.save-btn')
        </button>
    </div>
</div>
