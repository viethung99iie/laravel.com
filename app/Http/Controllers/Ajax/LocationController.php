<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $districtRepository;
    protected $provinceRepository;

    public function __construct(
        DistrictRepository $districtRepository,
        ProvinceRepository $provinceRepository
    ){
        $this->districtRepository = $districtRepository;
        $this->provinceRepository = $provinceRepository;
    }


    public function getLocation(Request $request ){
        $location = $request->input();
        $html ='';
        if($location['target']=='districts'){
            $province = $this->provinceRepository->findById($location['data_id'],['code','name'],[$location['target']]);
             $html = $this->rederHtml($province->districts,'[Chọn Quận/Huyện]');
        }
        elseif($location['target']=='wards'){
             $district = $this->districtRepository->findById($location['data_id'],['code','name'],[$location['target']]);
             $html = $this->rederHtml($district->wards,'[Chọn Phường/Xã]');
        }

        $response = [
            'html' => $html,
        ];
        return response()->json($response);

    }

    public function rederHtml($districts,$root ='[Chọn Quận/Huyện]'){
        $html = '<option value="0">'.$root.'</option>';
        foreach($districts as $district){
            $html .= '<option value="'.$district->code.'">'.$district->name.'</option>';
        }
        return $html;
    }
}