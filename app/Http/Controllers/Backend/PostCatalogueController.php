<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostCatalogueRequest;
use App\Http\Requests\StorePostCatalogueRequest;
use App\Http\Requests\UpdatePostCatalogueRequest;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use Illuminate\Http\Request;

class PostCatalogueController extends Controller
{
    protected $postCatalogueService;
    protected $postCatalogueRepository;
    protected $nestedSet;
    protected $language;

    public function __construct(
        PostCatalogueService $postCatalogueService,
        PostCatalogueRepository $postCatalogueRepository,
    ) {
        $this->postCatalogueService = $postCatalogueService;
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedSet = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->currentLanguage(),
        ]);
        $this->language = $this->currentLanguage();
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'post.catalogue.index');

        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'model' => 'PostCatalogue',
        ];
        $config['seo'] = config('apps.postcatalogue');
        $postCatalogues = $this->postCatalogueService->paginate($request);
        $template = 'backend.post.catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'postCatalogues',
        ));
    }
    public function create()
    {
        $this->authorize('modules', 'post.catalogue.create');

        $dropDown = $this->nestedSet->Dropdown();
        $config = $this->config();
        $config['seo'] = config('apps.postcatalogue');
        $config['method'] = 'create';

        $template = 'backend.post.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropDown',
        ));
    }

    public function store(StorePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->create($request)) {
            return redirect()->route('post.catalogue.index')->with('success', 'Thêm mới bảng ghi thành công');
        }
        return redirect()->route('post.catalogue.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'post.catalogue.edit');

        $dropDown = $this->nestedSet->Dropdown();
        $post = $this->postCatalogueRepository->getPostCatalogueById($id, $this->language);
        $config = $this->config();
        $config['seo'] = config('apps.postcatalogue');
        $config['method'] = 'edit';
        $template = 'backend.post.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'post',
            'dropDown',
        ));
    }

    public function update($id, UpdatePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->update($id, $request)) {
            return redirect()->route('post.catalogue.index')->with('success', 'Cập nhật bảng ghi thành công');
        }
        return redirect()->route('post.catalogue.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'post.catalogue.destroy');

        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($id, $this->language);
        $config['seo'] = config('apps.postcatalogue');
        $template = 'backend.post.catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'postCatalogue'
        ));
    }

    public function destroy(DeletePostCatalogueRequest $request, $id)
    {
        if ($this->postCatalogueService->delete($id)) {
            return redirect()->route('post.catalogue.index')->with('success', 'Xóa người dùng thành công');
        }
        return redirect()->route('post.catalogue.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }
    private function config()
    {
        return [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/library/seo.js',
                'backend/library/finder.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
        ];
    }
}
