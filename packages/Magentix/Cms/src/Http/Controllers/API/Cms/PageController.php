<?php

namespace Magentix\Cms\Http\Controllers\API\Cms;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Magentix\Cms\ApiDataSource\PageDataSource;
use Magentix\Cms\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Response;
use Webkul\AdminApi\Http\Controllers\API\ApiController;

class PageController extends ApiController
{
    public function __construct(
        protected PageDataSource $pageDataSource,
        protected PageRepository $pageRepository
    ) {}

    public function getList(): JsonResponse
    {
        try {
            return app(PageDataSource::class)->toJson();
        } catch (Exception $e) {
            return $this->storeExceptionLog($e);
        }
    }

    public function get(string $code): JsonResponse
    {
        try {
            return response()->json(app(PageDataSource::class)->getByCode($code));
        } catch (Exception $e) {
            return $this->storeExceptionLog($e);
        }
    }

    public function store(): JsonResponse
    {
        try {
            $this->validate(request(), [
                'group'  => ['required'],
                'code'   => ['required', 'unique:cms_pages,code'],
                'slug'   => ['required', 'unique:cms_pages,slug'],
                'title'  => ['required'],
                'locale' => ['required', 'in:'.implode(',', $this->getLocaleCodes())],
                'status' => ['in:0,1'],
            ]);
        } catch (Exception $exception) {
            return $this->validateErrorResponse([$exception->getMessage()]);
        }

        $request = request()->only(['title', 'content', 'locale', 'group', 'code', 'slug', 'status']);

        try {
            Event::dispatch('cms.page.create.before');

            $entity = $this->pageRepository->create($request);

            Event::dispatch('cms.page.create.after', $entity);

            return $this->successResponse(trans('cms::app.cms.pages.create-success'), Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->storeExceptionLog($e);
        }
    }

    public function update(string $code): JsonResponse
    {
        $entity = $this->pageRepository->findOneByField('code', $code);
        if (! $entity) {
            return $this->modelNotFoundResponse(trans('cms::app.cms.pages.not-found', ['code' => $code]));
        }

        try {
            $this->validate(request(), [
                'group'  => ['required'],
                'slug'   => ['required', 'unique:cms_pages,slug,'.$entity->id],
                'title'  => ['required'],
                'locale' => ['required', 'in:'.implode(',', $this->getLocaleCodes())],
                'status' => ['in:0,1'],
            ]);
        } catch (Exception $exception) {
            return $this->validateErrorResponse([$exception->getMessage()]);
        }

        try {
            Event::dispatch('cms.page.update.before', $entity->id);

            $entity = $this->pageRepository->update(
                request()->only(['title', 'content', 'locale', 'slug', 'group', 'status']),
                $entity->id
            );

            Event::dispatch('cms.page.update.after', $entity);

            return $this->successResponse(trans('cms::app.cms.pages.update-success'), Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->storeExceptionLog($e);
        }
    }

    protected function getLocaleCodes(): array
    {
        return core()->getAllLocales()->pluck('code')->toArray();
    }
}
