<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ProjectsRequest;
use App\Http\Services\Deeds\ProjectService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    protected $projectService;

    /**
     * ProjectController constructor.
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(){

        return view('user.project.project');
    }

    /**
     * @return JsonResponse
     */
    public function projectData(){

        return response()->json($this->projectService->getProjectData());

    }

    /**
     * @param ProjectsRequest $request
     * @return JsonResponse
     */
    public function storeProject(ProjectsRequest $request){

        return response()->json($this->projectService->storeProjectData($request));
    }

    /**
     * @param ProjectsRequest $request
     * @return JsonResponse
     */
    public function updateProject(ProjectsRequest $request){

        return response()->json($this->projectService->updateProjectData($request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteProject(Request $request){

        return response()->json($this->projectService->destroyProjectData($request));
    }
}
