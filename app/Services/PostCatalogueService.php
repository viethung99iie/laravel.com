<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use App\Services\Interfaces\PostCatalogueServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class PostService
 * @package App\Services
 */
class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    protected $routerRepository;
    protected $nestedSet;
    protected $controllerName = 'PostCatalogueController';

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        RouterRepository $routerRepository,
        Nestedsetbie $nestedSet
    ) {
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->routerRepository = $routerRepository;
        $this->nestedSet = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->currentLanguage(),
        ]);
    }
    public function paginate($request)
    {
        $conditions = [
            'keywords' => addslashes($request->get('keywords')),
            'publish' => $request->integer('publish'),
        ];
        $perpage = $request->integer('perpage');
        $paginationConfig = [
            'groupBy' => $this->select(),
        ];
        $orderBy = [];
        $joins = [
            [
                'post_catalogue_language as tb2',
                'tb2.post_catalogue_id',
                '=',
                'post_catalogues.id',
            ],
        ];

        $posts = $this->postCatalogueRepository->paginate(
            $this->select(),
            $conditions,
            $perpage,
            $paginationConfig,
            $orderBy,
            $joins,
        );
        return $posts;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->createPostCatalogue($request);

            if ($postCatalogue->id > 0) {
                $this->updateLanguageForPostCatalogue($request, $postCatalogue);
                $this->createRouter($postCatalogue, $request, $this->controllerName);
                $this->nestedset = new Nestedsetbie([
                    'table' => 'post_catalogues',
                    'foreignkey' => 'post_catalogue_id',
                    'language_id' => $this->currentLanguage(),
                ]);
                $this->nestedset();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->postCatalogueRepository->findById($id);
            $flag = $this->updateCatalogue($postCatalogue, $request);
            if ($flag == true) {
                $this->updateLanguageForPostCatalogue($request, $postCatalogue);
                $this->updateRouter($postCatalogue, $request, $this->controllerName);
                $this->nestedset = new Nestedsetbie([
                    'table' => 'post_catalogues',
                    'foreignkey' => 'post_catalogue_id',
                    'language_id' => $this->currentLanguage(),
                ]);
                $this->nestedset();

            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->postCatalogueRepository->delete($id);
            $this->nestedSet->Get('level ASC, order ASC');
            $this->nestedSet->Recursive(0, $this->nestedSet->Set());
            $this->nestedSet->Action();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }
    public function updateStatus($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] != 2) ? 2 : 1);
            $postCatalogue = $this->postCatalogueRepository->update($post['modelId'], $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }

    }
    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];
            $flag = $this->postCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    private function createPostCatalogue($request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::user()->id;
        $payload['album'] = $this->formatAlbum($request);
        $postCatalgue = $this->postCatalogueRepository->create($payload);
        return $postCatalgue;

    }
    private function updateCatalogue($postCatalogue, $request)
    {
        $payload = $request->only($this->payload());
        $payload['album'] = $this->formatAlbum($request);
        $flag = $this->postCatalogueRepository->update($postCatalogue->id, $payload);
        return $flag;
    }
    private function updateLanguageForPostCatalogue($request, $postCatalogue)
    {
        $payload = $this->formatLanguagePayload($request, $postCatalogue);
        $languages = $this->postCatalogueRepository->createPivot($postCatalogue, $payload, 'languages');
    }
    private function formatLanguagePayload($request, $postCatalogue)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload['post_catalogue_id'] = $postCatalogue->id;
        $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] = $this->currentLanguage();
        return $payload;
    }
    private function select()
    {
        return [
            'post_catalogues.id',
            'post_catalogues.lft',
            'post_catalogues.level',
            'post_catalogues.publish',
            'post_catalogues.album',
            'tb2.name',
            'tb2.canonical',
        ];
    }

    private function payload()
    {
        return [
            'publish',
            'follow',
            'parent_id',
            'image',
            'album',
        ];
    }

    private function payloadLanguage()
    {
        return [
            'name',
            'description',
            'content',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'canonical',
        ];
    }
}
