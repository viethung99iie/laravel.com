<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
    }

    public function index(){
        $config = $this->getConfig();

        $template = 'backend.dashboard.home.index';
        return view('backend.dashboard.layout',compact(
            'template',
            'config',
        ));
    }

    private function getConfig(){
        $config = [
            'js' => [
                'backend/js/plugins/flot/jquery.flot.time.js',
                'backend/js/plugins/flot/jquery.flot.symbol.js',
                'backend/js/plugins/flot/jquery.flot.pie.js',
                'backend/js/plugins/flot/jquery.flot.resize.js',
                'backend/js/plugins/flot/jquery.flot.spline.js',
                'backend/js/plugins/flot/jquery.flot.tooltip.min.js',
                'backend/js/plugins/flot/jquery.flot.js',
                'backend/js/demo/sparkline-demo.js',
                'backend/js/plugins/sparkline/jquery.sparkline.min.js',
                'backend/js/plugins/easypiechart/jquery.easypiechart.js',
                'backend/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
                'backend/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
                'backend/js/plugins/jquery-ui/jquery-ui.min.js',
                'backend/js/plugins/pace/pace.min.js',
                'backend/js/inspinia.js',
                'backend/js/demo/peity-demo.js',
                'backend/js/plugins/peity/jquery.peity.min.js',
            ]
        ];
        return $config;
    }
}
