<?php

namespace Magentix\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Magentix\Cms\Repository\PageRepository;
use Webkul\DataGrid\DataGrid;

class PageDataGrid extends DataGrid
{
    public function __construct(protected PageRepository $pageRepository) {}

    public function prepareQueryBuilder(): Builder
    {
        $tablePrefix = DB::getTablePrefix();

        return DB::table($tablePrefix.'cms_pages')->select();
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'code',
            'label'      => trans('cms::app.cms.pages.index.grid.code'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'group',
            'label'      => trans('cms::app.cms.pages.index.grid.group'),
            'type'       => 'dropdown',
            'options'    => [
                'type'   => 'basic',
                'params' => [
                    'options' => $this->getGroupOptions(),
                ],
            ],
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('cms::app.cms.pages.index.grid.title'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'locale',
            'label'      => trans('cms::app.cms.pages.index.grid.locale'),
            'type'       => 'dropdown',
            'options'    => [
                'type'   => 'basic',
                'params' => [
                    'options' => $this->getLocaleOptions(),
                ],
            ],
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
            'closure'    => fn ($row) => $this->getLocaleLabel($row->locale),
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('cms::app.cms.pages.index.grid.status'),
            'type'       => 'dropdown',
            'options'    => [
                'type'   => 'basic',
                'params' => [
                    'options' => [
                        ['value' => 0, 'label' => trans('cms::app.cms.pages.disabled')],
                        ['value' => 1, 'label' => trans('cms::app.cms.pages.enabled')],
                    ],
                ],
            ],
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
            'closure'    => fn ($row) => $row->status
                ? '<span class="label-active">'.trans('cms::app.cms.pages.enabled').'</span>'
                : '<span class="label-processing">'.trans('cms::app.cms.pages.disabled').'</span>',
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('cms::app.cms.pages.index.grid.created_at'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.pages.edit')) {
            $this->addAction([
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.cms.pages.index.grid.edit'),
                'method' => 'GET',
                'url'    => function ($row) {
                    return route('admin.cms.pages.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('cms.pages.delete')) {
            $this->addAction([
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.cms.pages.index.grid.delete'),
                'method' => 'DELETE',
                'url'    => function ($row) {
                    return route('admin.cms.pages.delete', $row->id);
                },
            ]);
        }
    }

    protected function getGroupOptions(): array
    {
        $groups = [];
        foreach ($this->pageRepository->getGroups() as $group) {
            $groups[] = ['value' => $group, 'label' => $group];
        }

        return $groups;
    }

    protected function getLocaleOptions(): array
    {
        $locales = [];
        foreach (core()->getAllActiveLocales() as $locale) {
            $locales[] = ['value' => $locale->code, 'label' => $locale->name];
        }

        return $locales;
    }

    protected function getLocaleLabel(string $code): string
    {
        foreach (core()->getAllActiveLocales() as $locale) {
            if ($locale->code === $code) {
                return $locale->name;
            }
        }

        return $code;
    }
}
