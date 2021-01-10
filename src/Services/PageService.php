<?php

namespace WriteLabel\Services\Points;

use WriteLabel\Entities\Points\Type;

class PageService
{

    protected $type = false;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public static function getService(Type $type)
    {
        return new static($type);
    }

    public function getView()
    {
        return view('writelabel::pages.points.index');
    }

}
