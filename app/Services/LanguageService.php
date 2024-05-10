<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Services\Interfaces\LanguageServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LanguageService implements LanguageServiceInterface
{
    // protected $languageRepository;
    protected $languageRepository;

    public function __construct(
        // languageCatalogueRepository $languageCatalogueRepository,
        LanguageRepository $languageRepository
    ) {
        // $this->languageCatalogueRepository = $languageCatalogueRepository;
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
