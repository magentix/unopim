<?php

namespace Magentix\CmsCustom\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'cms.page.update.after' => [
            'Magentix\CmsCustom\Listeners\CustomPage@update',
        ],
        'cms.page.create.after' => [
            'Magentix\CmsCustom\Listeners\CustomPage@update',
        ],
        'unopim.admin.cms.pages.edit.card.form.after' => [
            'Magentix\CmsCustom\Listeners\CustomPage@addFields',
        ],
        'unopim.admin.cms.pages.create.card.form.after' => [
            'Magentix\CmsCustom\Listeners\CustomPage@addFields',
        ],
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'cms-custom');
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'cms-custom');
    }
}
