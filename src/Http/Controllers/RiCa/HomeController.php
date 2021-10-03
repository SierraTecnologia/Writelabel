<?php

namespace WriteLabel\Http\Controllers\RiCa;

use WriteLabel\Services\RootService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $rootService;

    public function __construct(RootService $rootService)
    {
        parent::__construct();

        $this->rootService = $rootService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('writelabel::root.home.index');
    }
}
