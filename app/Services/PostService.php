<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

/**
 * Class PostService
 * @package App\Services
 */
class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;

    public function __construct(
        PostRepository $postRepository,
        ){
            $this->postRepository = $postRepository;
        }
    public function paginate($request){
        $conditions['keywords'] = addslashes($request->get('keywords'));
        $perpage =  20;
        if($request->get('perpage')!=null){
            $perpage = $request->integer('perpage');
        }
        if($request->integer('publish')>=0){
            $conditions['publish'] = $request->integer('publish');
        }
        $posts = $this->postRepository->paginate(
            $this->select(),
            $conditions,
            $perpage,
            [
                // ['post.lft','asc']
            ],
        );
        return $posts;
    }

    public function create($request){
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $payload['user_id'] = Auth::user()->id;
           if(count($payload['album'])){
               $payload['album'] = json_encode($payload['album']);
           }
            $post = $this->postRepository->create($payload);
            if($post->id > 0){
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['post_id'] = $post->id;
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $languages = $this->postRepository->createPivot($post,$payloadLanguage,'languages');

                $catalogue = $this->catalogue($request);
                $post->post_catalogues()->sync($catalogue);

            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }

     public function update($id,$request){
        DB::beginTransaction();
        try {
            $post = $this->postRepository->findById($id);
            $payload = $request->except('_token','send');
            $flag = $this->postRepository->update($id,$payload);
            if($flag== TRUE){
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['post__id'] = $id;
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $post->languages()
                              ->detach([$payloadLanguage['language_id'],$id]);
                $response = $this->postRepository
                                 ->createPivot($post,$payloadLanguage,'lan');
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

    public function delete($id){
        DB::beginTransaction();
        try {
            $post = $this->postRepository->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    public function updateStatus($post){
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value']!=2)?2:1);
            $post = $this->postRepository->update($post['modelId'],$payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }

    }
    public function updateStatusAll($post){
       DB::beginTransaction();
        try {
            $payload[$post['field']]= $post['value'];
            $flag = $this->postRepository->updateByWhereIn('id',$post['id'],$payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
    private function catalogue($request){
        return array_unique(array_merge($request->input('catalogue'),[$request->post_catalogue_id]));
    }

    private function select(){
        return [
            'posts.id',
            'posts.publish',
            // 'tb2.name',
            // 'tb2.canonical',
        ];
    }

    private function payload(){
        return  [
                    'publish',
                    'follow',
                    'parent_id',
                    'image',
                    'album',
                    'post_catalogue_id',
                ];
    }

    private function payloadLanguage(){
        return  [
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
