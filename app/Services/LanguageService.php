<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use App\Services\Interfaces\LanguageServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LanguageService implements LanguageServiceInterface
{
    // protected $languageRepository;
    protected $languageRepository;
    protected $routerRepository;

    public function __construct(
        RouterRepository $routerRepository,
        LanguageRepository $languageRepository
    ) {
        $this->routerRepository = $routerRepository;
        $this->languageRepository = $languageRepository;
    }
    public function paginate($request)
    {
        $conditions['keywords'] = addslashes($request->get('keywords'));
        $perpage = $request->integer('perpage');
        $conditions['publish'] = $request->integer('publish');
        $paginationConfig = [
            'groupBy' => $this->select(),
        ];
        $orderBy = [];

        $languages = $this->languageRepository->paginate(
            $this->select(),
            $conditions,
            $perpage,
            $paginationConfig,
            $orderBy,
        );
        return $languages;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except('_token', 'send');
            $payload['user_id'] = Auth::user()->id;
            $language = $this->languageRepository->create($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except('_token', 'send');
            $language = $this->languageRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->languageRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function updateStatus($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] != 2) ? 2 : 1);
            $language = $this->languageRepository->update($post['modelId'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];
            $flag = $this->languageRepository->updateByWhereIn('id', $post['id'], $payload);
            $this->changeUserStatus($post, $post['value']);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }

    public function switch($id)
    {
            DB::beginTransaction();
            try {
                $language = $this->languageRepository->update($id, ['current' => 1]);
                $payload = ['current' => 0];
                $where = [
                    ['id', '!=', $id],
                ];
                $this->languageRepository->updateByWhere($where, $payload);

                DB::commit();
                return true;
            } catch (\Exception $e) {
                //throw $th;
                DB::rollBack();
                echo $e->getMessage();die();
                return false;
            }
    }
    public function saveTranslate($option, $request)
    {
        DB::beginTransaction();
        try {
            $payload = [
                'name' => $request->input('translate_name'),
                'description' => $request->input('translate_description'),
                'content' => $request->input('translate_content'),
                'meta_title' => $request->input('translate_meta_title'),
                'meta_keyword' => $request->input('translate_meta_keyword'),
                'meta_description' => $request->input('translate_meta_description'),
                'canonical' => $request->input('translate_canonical'),
                $this->converModelToField($option['model']) => $option['id'],
                'language_id' => $option['languageId'],
            ];
            $controllerName = $option['model'] . 'Controller';
            $repositoryNamespace = '\App\Repositories\\' . ucfirst($option['model']) . 'Repository';
            if (class_exists($repositoryNamespace)) {
                $repositoryInstance = app($repositoryNamespace);
            }
            $model = $repositoryInstance->findById($option['id']);
            $model->languages()->detach([$option['languageId'], $model->id]);
            $repositoryInstance->createPivot($model, $payload, 'languages');

            $this->routerRepository->forceDeleteByCondition(
                [
                    ['module_id', '=', $option['id']],
                    ['controllers', '=', 'App\Http\Controllers\Frontend\\' . $controllerName],
                    ['language_id', '=', $option['languageId']],
                ]
            );
            $router = [
                'canonical' => Str::slug($request->input('translate_canonical')),
                'module_id' => $model->id,
                'language_id' => $option['languageId'],
                'controllers' => 'App\Http\Controllers\Frontend\\' . $controllerName . '',
            ];
            $this->routerRepository->create($router);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }
    private function converModelToField($model)
    {
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $model));
        return $temp . '_id';
    }

    private function select()
    {
        return [
            'id',
            'name',
            'description',
            'image',
            'canonical',
            'publish',
        ];
    }
}
