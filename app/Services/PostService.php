<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class PostService
 * @package App\Services
 */
class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;

    protected $controllerName = 'PostController';

    public function __construct(
        PostRepository $postRepository,
    ) {
        $this->postRepository = $postRepository;
    }
    public function paginate($request, $languageId)
    {
        $conditions = [
            'keywords' => addslashes($request->get('keywords')),
            'publish' => $request->integer('publish'),
            'where' => [
                ['tb2.language_id', '=', $languageId],
            ],
        ];
        $perpage = $request->integer('perpage');
        $paginationConfig = [
            'groupBy' => $this->select(),
        ];
        $orderBy = [];
        $joins = [
            ['post_language as tb2', 'tb2.post_id', '=', 'posts.id'],
            ['post_catalogue_post as tb3', 'posts.id', '=', 'tb3.post_id'],
        ];
        $relations = ['post_catalogues'];
        $rawQuery = $this->whereRaw($request, $languageId);
        $posts = $this->postRepository->paginate(
            $this->select(),
            $conditions,
            $perpage,
            $paginationConfig,
            $orderBy,
            $joins,
            $relations,
            $rawQuery,
        );
        return $posts;
    }

    public function create($request, $languageId)
    {
        DB::beginTransaction();
        try {
            $post = $this->createPost($request);
            if ($post->id > 0) {
                $this->updateLanguageForPost($post, $request, $languageId);

                $this->updateCatalogueForPost($post, $request);

                $this->createRouter($post, $request, $this->controllerName);
                echo 123;die();

            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function update($id, $request, $languageId)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->findById($id);
            if ($this->updatePost($post, $request)) {
                $this->updateLanguageForPost($post, $request, $languageId);
                $this->updateCatalogueForPost($post, $request);
                $this->updateRouter($post, $request, $this->controllerName);
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
            $post = $this->postRepository->delete($id);
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

    private function createPost($request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::id();
        $payload['album'] = $this->formatAlbum($request);
        $post = $this->postRepository->create($payload);
        return $post;
    }

    private function updatePost($post, $request)
    {
        $payload = $request->only($this->payload());
        $payload['album'] = $this->formatAlbum($request);
        return $this->postRepository->update($post->id, $payload);

    }

    private function updateLanguageForPost($post, $request, $languageId)
    {
        $payload = $request->only($this->payload());
        $payload = $this->formatLanguagePayload($request, $post->id, $languageId);
        $post->languages()
            ->detach([$payload['language_id'], $post->id]);
        return $this->postRepository->createPivot($post, $payload, 'languages');
    }
    private function formatLanguagePayload($request, $postId, $languageId)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] = $languageId;
        $payload['post_id'] = $postId;
        return $payload;
    }
    private function updateCatalogueForPost($post, $request)
    {
        $post->post_catalogues()->sync($this->catalogue($request));
    }

    public function updateStatus($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] != 2) ? 2 : 1);
            $post = $this->postRepository->update($post['modelId'], $payload);

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
            $flag = $this->postRepository->updateByWhereIn('id', $post['id'], $payload);
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

    private function catalogue($request)
    {
        return array_unique(array_merge($request->input('catalogue'), [$request->post_catalogue_id]));
    }
    private function whereRaw($request, $languageId)
    {
        $rawCondition = [];
        if ($request->integer('post_catalogue_id') > 0) {
            $rawCondition['whereRaw'] = [
                'tb3.post_catalogue_id IN (
                        SELECT id
                        FROM post_catalogues
                        JOIN post_catalogue_language ON post_catalogues.id = post_catalogue_language.post_catalogue_id
                        WHERE lft >= (SELECT lft FROM post_catalogues as pc WHERE pc.id = ?)
                        AND rgt <= (SELECT rgt FROM post_catalogues as pc WHERE pc.id = ?)
                        AND post_catalogue_language.language_id = ' . $languageId . '
                    )',
                [$request->integer('post_catalogue_id'), $request->integer('post_catalogue_id')],
            ];
        }
        return $rawCondition;
    }

    private function select()
    {
        return [
            'posts.id',
            'posts.publish',
            'posts.image',
            'posts.order',
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
            'post_catalogue_id',
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
