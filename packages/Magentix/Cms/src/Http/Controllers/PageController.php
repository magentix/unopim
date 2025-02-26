<?php

namespace Magentix\Cms\Http\Controllers;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Magentix\Cms\DataGrids\PageDataGrid;
use Magentix\Cms\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function __construct(protected PageRepository $pageRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return app(PageDataGrid::class)->toJson();
        }

        return view('cms::cms.pages.index');
    }

    /**
     * Edit
     */
    public function edit(int $id): View
    {
        $entity = $this->pageRepository->findOrFail($id);

        if ($entity->locale) {
            App::setLocale($entity->locale);
        }

        $groups = $this->getFormGroupOptions();
        $statuses = $this->getFormStatusOptions();

        return view('cms::cms.pages.edit', compact('entity', 'groups', 'statuses'));
    }

    /**
     * Create
     */
    public function create(): View
    {
        $groups = $this->getFormGroupOptions();
        $statuses = $this->getFormStatusOptions();

        return view('cms::cms.pages.create', compact('groups', 'statuses'));
    }

    /**
     * Update
     */
    public function update(FormRequest $request, int $id): RedirectResponse
    {
        try {
            if (! $request->get('status')) {
                $request->merge(['status' => 0]);
            }

            session()->flashInput($request->toArray());

            if ($request->get('new_group')) {
                $request->merge(['group' => $request->get('new_group')]);
            }

            $this->validate($request, [
                'group'  => ['required'],
                'slug'   => ['required', 'unique:cms_pages,slug,'.$id],
                'title'  => ['required'],
                'locale' => ['required', 'in:'.implode(',', $this->getLocaleCodes())],
                'status' => ['in:0,1'],
            ]);

            Event::dispatch('cms.page.update.before', $id);

            $entity = $this->pageRepository->update(
                $request->only(['title', 'content', 'locale', 'slug', 'group', 'status']),
                $id
            );

            Event::dispatch('cms.page.update.after', $entity);

            session()->forget('_old_input');
            session()->flash('success', trans('cms::app.cms.pages.update-success'));
        } catch (Exception $exception) {
            session()->flash('error', $exception->getMessage());
        }

        return redirect()->route('admin.cms.pages.edit', ['id' => $id, 'locale' => core()->getRequestedLocaleCode()]);
    }

    /**
     * Store
     */
    public function store(Request $request): RedirectResponse
    {
        $locale = core()->getRequestedLocaleCode();

        try {
            if (! $request->get('status')) {
                $request->merge(['status' => 0]);
            }

            session()->flashInput($request->toArray());

            if ($request->get('new_group')) {
                $request->merge(['group' => $request->get('new_group')]);
            }

            $this->validate($request, [
                'group'  => ['required'],
                'code'   => ['required', 'unique:cms_pages,code'],
                'slug'   => ['required', 'unique:cms_pages,slug'],
                'title'  => ['required'],
                'locale' => ['required', 'in:'.implode(',', $this->getLocaleCodes())],
                'status' => ['in:0,1'],
            ]);

            Event::dispatch('cms.page.create.before');

            $entity = $this->pageRepository->create(
                $request->only(['title', 'content', 'locale', 'code', 'slug', 'group', 'status'])
            );

            Event::dispatch('cms.page.create.after', $entity);

            session()->forget('_old_input');
            session()->flash('success', trans('cms::app.cms.pages.create-success'));

            return redirect()->route('admin.cms.pages.edit', ['id' => $entity->id, 'locale' => $locale]);
        } catch (Exception $exception) {
            session()->flash('error', $exception->getMessage());

            return redirect()->route('admin.cms.pages.create', ['locale' => $locale]);
        }
    }

    /**
     * Remove
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $entity = $this->pageRepository->findOrFail($id);

            Event::dispatch('cms.page.delete.before', $id);

            $entity->delete($id);

            Event::dispatch('cms.page.delete.after', $id);

            return new JsonResponse([
                'message' => trans('cms::app.cms.pages.delete-success', ['id' => $entity->id]),
            ]);
        } catch (Exception $exception) {
            report($exception);

            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function getFormGroupOptions(): string
    {
        $groups = [];
        foreach ($this->pageRepository->getGroups() as $group) {
            $groups[] = ['id' => $group, 'label' => $group];
        }

        return count($groups) ? json_encode($groups) : '';
    }

    protected function getFormStatusOptions(): string
    {
        return json_encode(
            [
                ['id' => 0, 'label' => trans('cms::app.cms.pages.disabled')],
                ['id' => 1, 'label' => trans('cms::app.cms.pages.enabled')],
            ]
        );
    }

    protected function getLocaleCodes(): array
    {
        return core()->getAllLocales()->pluck('code')->toArray();
    }
}
