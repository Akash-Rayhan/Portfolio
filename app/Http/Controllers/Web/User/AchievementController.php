<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\AchievementsRequest;
use App\Http\Services\Deeds\AchievementService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AchievementController extends Controller
{
    protected $achievementService;

    /**
     * AchievementController constructor.
     * @param AchievementService $achievementService
     */
    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(){

        return view('user.achievement.achievement');
    }

    /**
     * @return JsonResponse
     */
    public function achievementData(){

        return response()->json($this->achievementService->getAchievementData());
    }

    /**
     * @param AchievementsRequest $request
     * @return JsonResponse
     */
    public function storeAchievement(AchievementsRequest $request){

        return response()->json($this->achievementService->storeAchievementData($request));
    }

    /**
     * @param AchievementsRequest $request
     * @return JsonResponse
     */
    public function updateAchievement(AchievementsRequest $request){

        return response()->json($this->achievementService->updateAchievementData($request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAchievement(Request $request){

        return response()->json($this->achievementService->destroyAchievementData($request));
    }
}
