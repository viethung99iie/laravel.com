<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Support\Str;

/**
 * Class LanguageService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{

    protected $routerRespository;
    protected $controllerName;
    protected $language;

    public function __construct(
        RouterRepository $routerRepository
    ) {
        $this->routerRepository = $routerRepository;
    }

    public function currentLanguage()
    {
        $locale = app()->getLocale();
        $language = Language::where('canonical', $locale)->first();
        return $language->id;
    }

    public function formatAlbum($request)
    {
        return ($request->input('album') && !empty($request->input('album'))) ? json_encode($request->input('album')) : '';
    }

    public function nestedset()
    {
        $this->nestedset->Get('level ASC, order ASC');
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();
    }

    public function formatRouterPayload($model, $request, $controllerName, $languageId)
    {
        $router = [
            'canonical' => Str::slug($request->input('canonical')),
            'module_id' => $model->id,
            'language_id' => $languageId,
            'controllers' => 'App\Http\Controllers\Frontend\\' . $controllerName . '',
        ];
        return $router;
    }

    public function createRouter($model, $request, $controllerName, $languageId)
    {
        $router = $this->formatRouterPayload($model, $request, $controllerName, $languageId);
        $this->routerRepository->create($router);
    }

    public function updateRouter($model, $request, $controllerName, $languageId)
    {
        $payload = $this->formatRouterPayload($model, $request, $controllerName);
        $condition = [
            ['module_id', '=', $model->id],
            ['controllers', '=', 'App\Http\Controllers\Frontend\\' . $controllerName],
        ];
        $router = $this->routerRepository->findByCondition($condition);
        $res = $this->routerRepository->update($router->id, $payload);
        return $res;
    }

}
