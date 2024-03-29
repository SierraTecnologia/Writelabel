<?php

namespace WriteLabel\Http\Controllers\User;

use WriteLabel\Services\ProfileService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        parent::__construct();

        $this->profileService = $profileService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('writelabel::profile.home.index');
    }
}
