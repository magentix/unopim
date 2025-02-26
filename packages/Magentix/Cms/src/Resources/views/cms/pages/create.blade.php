<x-admin::layouts>
    <x-slot:title>
        @lang('cms::app.cms.pages.create.title')
    </x-slot>

    <x-admin::form method="POST" :action="route('admin.cms.pages.create')">

        {!! view_render_event('unopim.admin.cms.pages.create.create_form_control.before') !!}

        @include('cms::cms.pages.form.header')

        @include('cms::cms.pages.form.locales')

        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">
            <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">
                {!! view_render_event('unopim.admin.cms.pages.create.card.form.before') !!}

                <div class="p-4 bg-white dark:bg-cherry-900 rounded box-shadow">

                    <x-admin::form.control-group.control
                        type="hidden"
                        name="locale"
                        :value="core()->getRequestedLocaleCode()"
                    />

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.cms.pages.form.code')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="code"
                            rules="required"
                            :value="old('code')"
                        />

                        <x-admin::form.control-group.error control-name="code" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.cms.pages.form.status')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="switch"
                            name="status"
                            value="1"
                            :checked="1 == old('status')"
                        />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.cms.pages.form.group')
                        </x-admin::form.control-group.label>

                        @if ($groups)
                            <x-admin::form.control-group.control
                                type="select"
                                name="group"
                                :options="$groups"
                                :value="old('group')"
                            />
                        @endif

                        <x-admin::form.control-group.control
                            type="text"
                            name="new_group"
                            :style="'margin-top:5px'"
                            :placeholder="trans('cms::app.cms.pages.form.new-group')"
                            :value="old('new_group')"
                        />

                        <x-admin::form.control-group.error control-name="group" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.cms.pages.form.slug')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="slug"
                            rules="required"
                            :value="old('slug')"
                        />

                        <x-admin::form.control-group.error control-name="slug" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.cms.pages.form.title')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="title"
                            rules="required"
                            :value="old('title')"
                        />

                        <x-admin::form.control-group.error control-name="title" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('cms::app.cms.pages.form.content')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="content"
                            id="content"
                            :value="old('content')"
                            :tinymce="true"
                        />

                        <x-admin::form.control-group.error control-name="content" />
                    </x-admin::form.control-group>
                </div>

                {!! view_render_event('unopim.admin.cms.pages.create.card.form.after') !!}
            </div>
        </div>

        {!! view_render_event('unopim.admin.cms.pages.create.create_form_controls.after') !!}

    </x-admin::form>

    {!! view_render_event('unopim.admin.cms.pages.create.after') !!}

</x-admin::layouts>
