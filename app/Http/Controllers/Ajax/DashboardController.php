<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\UserServiceInterface as UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $userService;
    public function __construct(
        UserService $userService,
    ){
        $this->userService = $userService;
    }

    public function changeStatus(Request $request){
        $post = $request->input();
        $serviceInterfaceNamespace = 'App\Services\\'.ucfirst($post['model']).'Service';
        if(isset($serviceInterfaceNamespace)){
            $serviceInstance = app($serviceInterfaceNamespace);
        }
        $flag = $serviceInstance->updateStatus($post);
        return response(['flag' => $flag]);
    }

    public function changeStatusAll(Request $request){
        $post = $request->input();
        $serviceInterfaceNamespace = 'App\Services\\'.ucfirst($post['model']).'Service';
        if(isset($serviceInterfaceNamespace)){
            $serviceInstance = app($serviceInterfaceNamespace);
        }

        $flag = $serviceInstance->updateStatusAll($post);

        return response(['flag' => $flag]);
    }
}
