<?php

namespace Magentix\Cms\Repository;

use Magentix\Cms\Contracts\Page;
use Webkul\Core\Eloquent\Repository;

class PageRepository extends Repository
{
    public function model(): string
    {
        return Page::class;
    }

    public function queryBuilder(): PageRepository
    {
        $this->model = $this->model->newQuery();

        return $this;
    }

    public function getGroups(): array
    {
        return $this->model->newQuery()->distinct()->pluck('group')->toArray();
    }
}
