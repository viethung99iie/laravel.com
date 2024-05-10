<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userRepository;

    public function __construct(
        UserService $userService,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository
    ) {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'model' => 'User'
        ];
        $users = $this->userService->paginate($request);
        $config['seo'] = config('apps.user');

        $template = 'backend.user.user.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'users',
        ));
    }
    public function create()
    {
        $config = $this->config();
        $config['seo'] = config('apps.user');
        $config['method'] = 'create';
        $provinces = $this->provinceRepository->all();
        $template = 'backend.user.user.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'provinces',
        ));
    }

    public function store(StoreUserRequest $request)
    {
        if ($this->userService->create($request)) {
            return redirect()->route('user.index')->with('success', 'Thêm mới người dùng thành công');
        }
        return redirect()->route('user.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function edit($id)
    {
        $user = $this->userRepository->findById($id);
        $config = $this->config();
        $config['seo'] = config('apps.user');
        $config['method'] = 'edit';
        $provinces = $this->provinceRepository->all();
        $template = 'backend.user.user.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'provinces',
            'user'
        ));
    }

    public function update($id, UpdateUserRequest $request)
    {
        if ($this->userService->update($id, $request)) {
            return redirect()->route('user.index')->with('success', 'Cập nhật người dùng thành công');
        }
        return redirect()->route('user.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function delete($id)
    {
        $user = $this->userRepository->findById($id);
        $config['seo'] = config('apps.user');
        $template = 'backend.user.user.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'user'
        ));
    }

    public function destroy($id)
    {
        if ($this->userService->delete($id)) {
            return redirect()->route('user.index')->with('success', 'Xóa người dùng thành công');
        }
        return redirect()->route('user.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    private function config()
    {
        return [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/location.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
    }
}
