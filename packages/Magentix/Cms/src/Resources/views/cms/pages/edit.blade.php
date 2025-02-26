<x-admin::layouts.with-history>
    <x-slot:entityName>
        page
    </x-slot>
    <x-slot:title>
        @lang('cms::app.cms.pages.edit.title')
    </x-slot>

    <x-admin::form method="PUT" :action="route('admin.cms.pages.update', $entity->id)">

        {!! view_render_event('unopim.admin.cms.pages.edit.edit_form_control.before', ['entity' => $entity]) !!}

        @include('cms::cms.pages.form.header')

        @include('cms::cms.pages.form.locales')

        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">
            <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">
                {!! view_render_event('unopim.admin.cms.pages.edit.card.form.before', ['entity' => $entity]) !!}

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
                            class="cursor-not-allowed"
                            name="code"
                            rules="required"
                            :disabled="(boolean) $entity->code"
                            :value="old('code', $entity->code)"
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
                            :checked="1 == old('status', $entity->status)"
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
                                :value="old('group', $entity->group)"
                            />
                        @endif

                        <x-admin::form.control-group.control
                            type="text"
                            name="new_group"
                            :style="'margin-top:5px'"
                            :placeholder="trans('cms::app.cms.pages.form.new-group')"
                            :value="old('new_group')"
                        />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.cms.pages.form.slug')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="slug"
                            rules="required"
                            :value="old('slug', $entity->slug)"
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
                            :value="old('title', $entity->title)"
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
                            :value="old('content', $entity->content)"
                            :tinymce="true"
                        />

                        <x-admin::form.control-group.error control-name="content" />
                    </x-admin::form.control-group>
                </div>

                {!! view_render_event('unopim.admin.cms.pages.edit.card.form.after', ['entity' => $entity]) !!}
            </div>
        </div>

        {!! view_render_event('unopim.admin.cms.pages.edit.edit_form_controls.after', ['entity' => $entity]) !!}

    </x-admin::form>

    {!! view_render_event('unopim.admin.cms.pages.edit.after') !!}

</x-admin::layouts.with-history>
