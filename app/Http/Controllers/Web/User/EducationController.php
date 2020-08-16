<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\EducationRequest;
use App\Http\Services\EducationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationController extends Controller
{
    protected $educationService;

    /**
     * EducationController constructor.
     * @param EducationService $educationService
     */
    public function __construct(EducationService $educationService)
    {
        $this->educationService = $educationService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(){

        return view('user.education.education');
    }

    /**
     * @return array|JsonResponse
     */
    public function educationData(){
        return response()->json($this->educationService->getEducationData());
    }

    /**
     * @param EducationRequest $request
     * @return JsonResponse
     */
    public function storeEducation(EducationRequest $request){
        return response()->json($this->educationService->storeEducationFormData($request));
    }

    /**
     * @param EducationRequest $request
     * @return JsonResponse
     */
    public function updateEducation(EducationRequest $request){
        return response()->json($this->educationService->updateEducationData($request));
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function deleteEducation(Request $request){
        return response()->json($this->educationService->destroyEducationData($request));
    }
}
