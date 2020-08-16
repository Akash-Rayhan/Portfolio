<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ResumeRequest;
use App\Http\Services\ResumeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResumeController extends Controller
{
    protected $resumeService;

    /**
     * ResumeController constructor.
     * @param ResumeService $resumeService
     */
    public function __construct(ResumeService $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(){

        return view('user.resume.resume');
    }

    /**
     * @return JsonResponse
     */
    public function resumeData(){

        return response()->json($this->resumeService->getResumeData());
    }

    /**
     * @param ResumeRequest $request
     * @return array
     */
    public function storeResume(ResumeRequest $request){

        return $this->resumeService->storeResumeData($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteResume(Request $request){

        return response()->json($this->resumeService->destroyResumeData($request));
    }

    /**
     * @param Request $request
     * @return array|bool
     */
    public function downloadResume(Request $request){

        return $this->resumeService->downloadResumeFile($request);
    }
}
