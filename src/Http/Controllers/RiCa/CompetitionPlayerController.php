<?php

namespace WriteLabel\Http\Controllers\RiCa;

use WriteLabel\Models\CompetitionPlayer;
use WriteLabel\Services\WriteLabelService;
use Illuminate\Support\Facades\Schema;
use Pedreiro\CrudController;

class CompetitionPlayerController extends Controller
{
    use CrudController;


    public function __construct(CompetitionPlayer $model)
    {
        $this->model = $model;
        parent::__construct();
    }


    // public function index(Request $request)
    // {
    //     // $service = $this->service;

    //     $service = new \Support\Services\RepositoryService(new \Support\Services\ModelService(Field::class));
    //     $registros = $service->getTableData();
    //     //     $teams = $this->repositoryService->paginated($request->user()->id);

        

    //     return view(
    //         'support::components.repositories.index',
    //         compact('service', 'registros')
    //     );

    //     // return view(
    //     //     'casa::finances.index',
    //     //     compact('service')
    //     // );
    // }
}
