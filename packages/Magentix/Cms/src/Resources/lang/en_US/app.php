<?php

return [
    'acl' => [
        'cms'    => 'CMS',
        'pages'  => 'Pages',
        'create' => 'Create',
        'edit'   => 'Edit',
        'delete' => 'Delete',
    ],
    'exporters' => [
        'page' => [
            'title' => 'Pages',
        ],
    ],
    'cms' => [
        'pages' => [
            'index' => [
                'title' => 'Pages',
                'add'   => 'Add Page',
                'grid'  => [
                    'id'         => 'ID',
                    'group'      => 'Group',
                    'code'       => 'Code',
                    'slug'       => 'Slug',
                    'title'      => 'Title',
                    'locale'     => 'Locale',
                    'created_at' => 'Created',
                    'status'     => 'Status',
                ],
            ],
            'edit' => [
                'title' => 'Edit Page',
            ],
            'create' => [
                'title' => 'New Page',
            ],
            'form' => [
                'group'      => 'Group',
                'new-group'  => 'New Group',
                'code'       => 'Code',
                'slug'       => 'Slug',
                'title'      => 'Title',
                'locale'     => 'Locale',
                'created_at' => 'Created',
                'content'    => 'Content',
                'status'     => 'Status',
                'header'     => [
                    'title'    => 'Page',
                    'back-btn' => 'Back',
                    'save-btn' => 'Save Page',
                ],
            ],
            'not-found'      => 'Page with code ":code" was not found',
            'update-success' => 'Page updated successfully',
            'create-success' => 'Page created successfully',
            'delete-success' => 'Page deleted successfully',
            'disabled'       => 'Disabled',
            'enabled'        => 'Enabled',
        ],
    ],
];
