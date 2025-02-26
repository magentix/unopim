<?php

namespace Magentix\Cms\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Magentix\Cms\Models\Page::class,
    ];
}
