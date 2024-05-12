<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalogueRequest;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Services\Interfaces\UserCatalogueServiceInterface as UserCatalogueService;
use Illuminate\Http\Request;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userCatalogueRepository;
    protected $permissionRepository;

    public function __construct(
        UserCatalogueService $userCatalogueService,
        UserCatalogueRepository $userCatalogueRepository,
        PermissionRepository $permissionRepository,
    ) {
        $this->userCatalogueService = $userCatalogueService;
        $this->permissionRepository = $permissionRepository;
        $this->userCatalogueRepository = $userCatalogueRepository;
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'user.catalogue.index');

        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'model' => 'UserCatalogue',
        ];
        $config['seo'] = config('apps.usercatalogue');
        $userCatalogues = $this->userCatalogueService->paginate($request);
        $template = 'backend.user.catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogues',
        ));
    }
    public function create()
    {
        $this->authorize('modules', 'user.catalogue.create');

        $config['seo'] = config('apps.usercatalogue');
        $config['method'] = 'create';
        $template = 'backend.user.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreUserCatalogueRequest $request)
    {
        if ($this->userCatalogueService->create($request)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Thêm mới bảng ghi thành công');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'user.catalogue.edit');

        $userCatalogue = $this->userCatalogueRepository->findById($id);

        $config['seo'] = config('apps.usercatalogue');
        $config['method'] = 'edit';
        $template = 'backend.user.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogue'
        ));
    }

    public function update($id, StoreUserCatalogueRequest $request)
    {
        if ($this->userCatalogueService->update($id, $request)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Cập nhật bảng ghi thành công');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'user.catalogue.destroy');

        $userCatalogue = $this->userCatalogueRepository->findById($id);
        $config['seo'] = config('apps.usercatalogue');
        $template = 'backend.user.catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogue'
        ));
    }

    public function destroy($id)
    {
        if ($this->userCatalogueService->delete($id)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Xóa người dùng thành công');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function permission()
    {
        $config['seo'] = config('apps.usercatalogue');
        $permissions = $this->permissionRepository->all();
        $userCatalogues = $this->userCatalogueRepository->all();
        $template = 'backend.user.catalogue.permission';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'permissions',
            'userCatalogues',
        ));
    }

    public function updatePermission(Request $request)
    {
        if ($this->userCatalogueService->setPermission($request)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Cập Nhật thành công!');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');

    }
}
