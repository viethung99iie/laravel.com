<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;
    protected $postRepository;
    protected $nestedSet;
    protected $language;

    public function __construct(
        PostService $postService,
        PostRepository $postRepository,
    ) {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->nestedSet = new Nestedsetbie([
                'table' => 'post_catalogues',
                'foreignkey' => 'post_catalogue_id',
                'language_id'=> $this->currentLanguage(),
            ]);
        $this->language = $this->currentLanguage();
    }

    public function index(Request $request){
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css'=>[
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',

            ]
        ];
        $config['seo'] = config('apps.post');
        $posts = $this->postService->paginate($request);
        $template = 'backend.post.post.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'posts',
        ));
    }
    public function create(){
        $dropDown = $this->nestedSet->Dropdown();
        $config = $this->config();
        $config['seo'] = config('apps.postcatalogue');
        $config['method'] = 'create';
        $template = 'backend.post.post.store';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'dropDown',
        ));
    }

    public function store(StorePostRequest $request){
        if($this->postService->create($request)){
            return redirect()->route('post.index')->with('success','Thêm mới bảng ghi thành công');
        }
        return redirect()->route('post.index')->with('error','Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function edit($id){
        $dropDown = $this->nestedSet->Dropdown();
        $post = $this->postRepository->getPostById($id,$this->language);
        $config = $this->config();
        $config['seo'] = config('apps.post');
        $config['method'] = 'edit';
        $template = 'backend.post.post.store';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'post',
            'dropDown',
        ));
    }

    public function update($id,UpdatePostRequest $request){
        if($this->postService->update($id,$request)){
            return redirect()->route('post.index')->with('success','Cập nhật bảng ghi thành công');
        }
        return redirect()->route('post.index')->with('error','Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function delete($id){
        $post = $this->postRepository->getPostById($id,$this->language);
        $config['seo'] = config('apps.post');
        $template = 'backend.post.post.delete';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'post'
        ));
    }

    public function destroy($id){
        if($this->postService->delete($id)){
            return redirect()->route('post.index')->with('success','Xóa người dùng thành công');
        }
        return redirect()->route('post.index')->with('error','Đã có lỗi xảy ra, vui lòng  thử lại');
    }
    private function config(){
        return [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/library/seo.js',
                'backend/library/finder.js',
            ],
            'css'=>[
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
    }
}

