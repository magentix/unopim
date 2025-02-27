<?php

namespace Magentix\CmsCustom\Listeners;

use Illuminate\Http\Request;
use Magentix\Cms\Models\Page;
use Magentix\Cms\Repository\PageRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Webkul\Theme\ViewRenderEventManager;

class CustomPage
{
    public function __construct(protected PageRepository $pageRepository) {}

    /**
     * @throws ValidatorException
     */
    public function update(Page $entity, Request $request): void
    {
        $this->pageRepository->update(
            $request->only(['meta_title', 'meta_description']),
            $entity->id
        );
    }

    public function addFields(ViewRenderEventManager $viewRenderEventManager): void
    {
        $viewRenderEventManager->addTemplate('cms-custom::cms.pages.fields');
    }
}
