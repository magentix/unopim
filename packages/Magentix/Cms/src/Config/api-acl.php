<?php

return [
    [
        'key'   => 'api.cms',
        'name'  => 'cms::app.acl.cms',
        'route' => 'api.cms.pages.index',
        'sort'  => 4,
    ],
    [
        'key'   => 'api.cms.pages',
        'name'  => 'cms::app.acl.pages',
        'route' => 'api.cms.pages.index',
        'sort'  => 1,
    ],
    [
        'key'   => 'api.cms.pages.create',
        'name'  => 'cms::app.acl.create',
        'route' => 'api.cms.pages.store',
        'sort'  => 1,
    ],
    [
        'key'   => 'api.cms.pages.edit',
        'name'  => 'cms::app.acl.edit',
        'route' => 'api.cms.pages.update',
        'sort'  => 2,
    ],
];
