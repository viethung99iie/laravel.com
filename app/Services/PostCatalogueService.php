<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
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
    protected $nestedSet;

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        Nestedsetbie $nestedSet
    ) {
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedSet = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->currentLanguage(),
        ]);
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
        $joins = [
            ['post_catalogue_language as tb2',
                'tb2.post_catalogue_id', '=', 'post_catalogues.id'],
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
            $payload = $request->only($this->payload());
            $payload['user_id'] = Auth::user()->id;
            $payload['album'] = json_encode($payload['album']);
            $postCatalogue = $this->postCatalogueRepository->create($payload);
            if ($postCatalogue->id > 0) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['post_catalogue_id'] = $postCatalogue->id;
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $languages = $this->postCatalogueRepository->createPivot($postCatalogue, $payloadLanguage, 'languages');
            }
            $this->nestedSet->Get('level ASC, order ASC');
            $this->nestedSet->Recursive(0, $this->nestedSet->Set());
            $this->nestedSet->Action();
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
            $postCatalogue = $this->postCatalogueRepository->findById($id);
            $payload = $request->except('_token', 'send');
            $payload['user_id'] = Auth::user()->id;
            $payload['album'] = json_encode($payload['album']);
            $flag = $this->postCatalogueRepository->update($id, $payload);
            if ($flag == true) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['post_catalogue_id'] = $id;
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $postCatalogue->languages()
                    ->detach([$payloadLanguage['language_id'], $id]);
                $response = $this->postCatalogueRepository
                    ->createPivot($postCatalogue, $payloadLanguage, 'languages');
                $this->nestedSet->Get('level ASC, order ASC');
                $this->nestedSet->Recursive(0, $this->nestedSet->Set());
                $this->nestedSet->Action();
            }
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
            $postCatalogue = $this->postCatalogueRepository->delete($id);
            $this->nestedSet->Get('level ASC, order ASC');
            $this->nestedSet->Recursive(0, $this->nestedSet->Set());
            $this->nestedSet->Action();
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
            $postCatalogue = $this->postCatalogueRepository->update($post['modelId'], $payload);

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
            $flag = $this->postCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    // private function changeUserStatus($post,$value){
    //          DB::beginTransaction();
    //     try {
    //         if(isset($post['modelId'])){
    //             $array[] = $post['modelId'];
    //         }else{
    //             $array = $post['id'];
    //         }
    //          $payload[$post['field']]= $value;
    //         $this->postRepository->updateByWhereIn('user_catalogue_id',$array,$payload);
    //         DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         //throw $th;
    //         DB::rollBack();
    //         echo $e->getMessage();die();
    //         return false;
    //     }
    // }

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
