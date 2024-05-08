<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Services\Interfaces\LanguageServiceInterface as LanguageService;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected $languageService;
    protected $languageRepository;

    public function __construct(
        LanguageService $languageService,
        LanguageRepository $languageRepository,
    ) {
        $this->languageService = $languageService;
        $this->languageRepository = $languageRepository;
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
        $config['seo'] = config('apps.language');
        $languages = $this->languageService->paginate($request);
        $template = 'backend.language.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'languages',
        ));
    }
    public function create(){
        $config = $this->config();
        $config['seo'] = config('apps.language');
        $config['method'] = 'create';
        $template = 'backend.language.store';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
        ));
    }

    public function store(StoreLanguageRequest $request){
        if($this->languageService->create($request)){
            return redirect()->route('language.index')->with('success','Thêm mới bảng ghi thành công');
        }
        return redirect()->route('language.index')->with('error','Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function edit($id){
        $config = $this->config();
        $language = $this->languageRepository->findById($id);

        $config['seo'] = config('apps.language');
        $config['method'] = 'edit';
        $template = 'backend.language.store';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'language'
        ));
    }

    public function update($id,UpdateLanguageRequest $request){
        if($this->languageService->update($id,$request)){
            return redirect()->route('language.index')->with('success','Cập nhật bảng ghi thành công');
        }
        return redirect()->route('language.index')->with('error','Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function delete($id){
        $language = $this->languageRepository->findById($id);
        $config['seo'] = config('apps.language');
        $template = 'backend.language.delete';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
            'language'
        ));
    }

    public function destroy($id){
        if($this->languageService->delete($id)){
            return redirect()->route('language.index')->with('success','Xóa người dùng thành công');
        }
        return redirect()->route('language.index')->with('error','Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    private function config(){
        return
        [
            'js' => [
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
            ]
        ];
    }
}
