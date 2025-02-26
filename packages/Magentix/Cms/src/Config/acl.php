<?php

return [
    [
        'key'   => 'cms',
        'name'  => 'cms::app.acl.cms',
        'route' => 'admin.cms.index',
        'sort'  => 4,
    ],
    [
        'key'   => 'cms.pages',
        'name'  => 'cms::app.acl.pages',
        'route' => 'admin.cms.pages.index',
        'sort'  => 1,
    ],
    [
        'key'   => 'cms.pages.create',
        'name'  => 'cms::app.acl.create',
        'route' => 'admin.cms.pages.create',
        'sort'  => 1,
    ],
    [
        'key'   => 'cms.pages.edit',
        'name'  => 'cms::app.acl.edit',
        'route' => 'admin.cms.pages.edit',
        'sort'  => 2,
    ],
    [
        'key'   => 'cms.pages.delete',
        'name'  => 'cms::app.acl.delete',
        'route' => 'admin.cms.pages.delete',
        'sort'  => 3,
    ],
];
