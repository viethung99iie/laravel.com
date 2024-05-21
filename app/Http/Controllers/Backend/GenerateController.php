<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGenerateRequest;
use App\Http\Requests\UpdateGenerateRequest;
use App\Repositories\Interfaces\GenerateRepositoryInterface as GenerateRepository;
use App\Services\Interfaces\GenerateServiceInterface as GenerateService;
use Illuminate\Http\Request;

class GenerateController extends Controller
{
    protected $generateService;
    protected $generateRepository;

    public function __construct(
        GenerateService $generateService,
        GenerateRepository $generateRepository,
    ) {
        $this->generateService = $generateService;
        $this->generateRepository = $generateRepository;
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'generate.index');

        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',

            ],
        ];
        $config['seo'] = __('messages.generate');
        $generates = $this->generateService->paginate($request);
        $template = 'backend.generate.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'generates',
        ));
    }
    public function create()
    {
        $this->authorize('modules', 'generate.create');

        $config = $this->config();
        $config['seo'] = __('messages.generate');
        $config['method'] = 'create';
        $template = 'backend.generate.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreGenerateRequest $request)
    {
        if ($this->generateService->create($request)) {
            return redirect()->route('generate.index')->with('success', 'Thêm mới bảng ghi thành công');
        }
        return redirect()->route('generate.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'generate.edit');

        $config = $this->config();
        $generate = $this->generateRepository->findById($id);

        $config['seo'] = __('messages.generate');
        $config['method'] = 'edit';
        $template = 'backend.generate.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'language'
        ));
    }

    public function update($id, UpdateGenerateRequest $request)
    {
        if ($this->generateService->update($id, $request)) {
            return redirect()->route('generate.index')->with('success', 'Cập nhật bảng ghi thành công');
        }
        return redirect()->route('generate.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'generate.destroy');

        $generate = $this->generateRepository->findById($id);
        $config['seo'] = __('messages.generate');
        $template = 'backend.generate.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'language'
        ));
    }

    public function destroy($id)
    {
        if ($this->generateService->delete($id)) {
            return redirect()->route('generate.index')->with('success', 'Xóa người dùng thành công');
        }
        return redirect()->route('generate.index')->with('error', 'Đã có lỗi xảy ra, vui lòng  thử lại');
    }

    private function config()
    {
        return [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
        ];
    }
}
