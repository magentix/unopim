<div class="p-4 bg-white dark:bg-cherry-900 rounded box-shadow">
    <x-admin::form.control-group>
        <x-admin::form.control-group.label>
            @lang('cms-custom::app.cms.pages.form.meta_title')
        </x-admin::form.control-group.label>

        <x-admin::form.control-group.control
            type="text"
            name="meta_title"
            :value="old('meta_title', $entity->meta_title ?? '')"
        />

        <x-admin::form.control-group.error control-name="meta_title" />
    </x-admin::form.control-group>

    <x-admin::form.control-group>
        <x-admin::form.control-group.label>
            @lang('cms-custom::app.cms.pages.form.meta_description')
        </x-admin::form.control-group.label>

        <x-admin::form.control-group.control
            type="text"
            name="meta_description"
            :value="old('meta_description', $entity->meta_description ?? '')"
        />

        <x-admin::form.control-group.error control-name="meta_description" />
    </x-admin::form.control-group>
</div>
