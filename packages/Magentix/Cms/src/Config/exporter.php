<?php

return [
    'pages' => [
        'title'       => 'cms::app.exporters.page.title',
        'exporter'    => 'Magentix\Cms\Helpers\Exporters\Pages\Exporter',
        'source'      => 'Magentix\Cms\Repository\PageRepository',
        'filters'     => [
            'fields' => [
                [
                    'name'       => 'file_format',
                    'title'      => 'File Format',
                    'type'       => 'select',
                    'required'   => true,
                    'validation' => 'required',
                    'options'    => [
                        [
                            'value' => 'Csv',
                            'label' => 'CSV',
                        ], [
                            'value' => 'Xls',
                            'label' => 'XLS',
                        ], [
                            'value' => 'Xlsx',
                            'label' => 'XLSX',
                        ],
                    ],
                ],
                [
                    'name'     => 'with_media',
                    'title'    => 'With Media (not supported)',
                    'required' => false,
                    'type'     => 'boolean',
                ],
            ],
        ],
    ],
];
