<?php

namespace Magentix\Cms\ApiDataSource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Magentix\Cms\Repository\PageRepository;
use Webkul\AdminApi\ApiDataSource;

class PageDataSource extends ApiDataSource
{
    public function __construct(protected PageRepository $pageRepository) {}

    public function processRequestedFilters(array $requestedFilters)
    {
        return $this->queryBuilder->scopeQuery(function ($scopeQueryBuilder) use ($requestedFilters) {
            $this->setDefaultFilters($scopeQueryBuilder);

            foreach ($requestedFilters as $requestedColumn => $requestedValues) {
                $scopeQueryBuilder->where(function ($query) use ($requestedValues, $requestedColumn) {
                    foreach ($requestedValues as $value) {
                        $query = $this->operatorByFilter($query, $requestedColumn, $value);
                    }
                });
            }

            return $scopeQueryBuilder;
        });
    }

    public function prepareApiQueryBuilder(): PageRepository
    {
        $this->addFilter('code', ['=', 'IN', 'NOT IN']);
        $this->addFilter('group', ['=', 'IN', 'NOT IN']);
        $this->addFilter('locale', ['=', 'IN', 'NOT IN']);
        $this->addFilter('slug', ['=', 'IN', 'NOT IN']);
        $this->addFilter('status', ['=']);

        return $this->pageRepository->queryBuilder();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByCode(string $code): array
    {
        $this->prepareForSingleData();

        $requestedFilters = [
            'code' => [
                [
                    'operator' => '=',
                    'value'    => $code,
                ],
            ],
        ];

        $this->queryBuilder = $this->processRequestedFilters($requestedFilters);

        $data = $this->queryBuilder->first()?->toArray();

        if (! $data) {
            throw new ModelNotFoundException(
                trans('cms::app.cms.pages.not-found', ['code' => $code])
            );
        }

        return $data;
    }
}
