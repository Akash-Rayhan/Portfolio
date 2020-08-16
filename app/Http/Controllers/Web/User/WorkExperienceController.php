<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\WorkExperiencesRequest;
use App\Http\Services\WorkExperienceService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkExperienceController extends Controller
{
    protected $workExperienceService;

    /**
     * WorkExperienceController constructor.
     * @param WorkExperienceService $workExperienceService
     */
    public function __construct(WorkExperienceService $workExperienceService)
    {
        $this->workExperienceService = $workExperienceService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(){

        return view('user.workExperiences.workExperiences');
    }

    /**
     * @return JsonResponse
     */
    public function workExperienceData(){

        return response()->json($this->workExperienceService->getWorkExperienceData());
    }

    /**
     * @param WorkExperiencesRequest $request
     * @return JsonResponse
     */
    public function storeWorkExperience(WorkExperiencesRequest $request){

        return response()->json($this->workExperienceService->storeWorkExperienceData($request));
    }

    /**
     * @param WorkExperiencesRequest $request
     * @return JsonResponse
     */
    public function updateWorkExperience(WorkExperiencesRequest $request){

        return response()->json($this->workExperienceService->updateWorkExperienceData($request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteWorkExperience(Request $request){

        return response()->json($this->workExperienceService->destroyWorkExperienceData($request));
    }
}
