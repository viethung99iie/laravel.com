<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\Interfaces\LanguageServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class LanguageService implements LanguageServiceInterface
{
    // protected $languageRepository;
    protected $languageRepository;

    public function __construct(
        // languageCatalogueRepository $languageCatalogueRepository,
        LanguageRepository $languageRepository
        ){
            // $this->languageCatalogueRepository = $languageCatalogueRepository;
            $this->languageRepository = $languageRepository;
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
        $languages = $this->languageRepository->paginate(
            $this->select(),
            $conditions,
            $perpage,
            [['id','desc']]);
        return $languages;
    }

    public function create($request){
        DB::beginTransaction();
        try {
            $payload = $request->except('_token','send');
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

     public function update($id,$request){
        DB::beginTransaction();
        try {
            $payload = $request->except('_token','send');
            $language = $this->languageRepository->update($id,$payload);
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
    public function updateStatus($post){
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value']!=2)?2:1);
            $language = $this->languageRepository->update($post['modelId'],$payload);
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
            $flag = $this->languageRepository->updateByWhereIn('id',$post['id'],$payload);
            $this->changeUserStatus($post,$post['value']);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }

    private function select(){
        return [
            'id',
            'name',
            'description',
            'image',
            'canonical',
            'publish'
        ];
    }
}
