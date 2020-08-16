<?php


namespace App\Http\Services;
use App\Http\Repository\AchievementRepository;
use App\Http\Services\Boilerplate\BaseService;
use Exception;
use Illuminate\Support\Facades\Auth;

class AchievementService extends BaseService
{
    /**
     * AchievementService constructor.
     * @param AchievementRepository $achievementRepository
     */
    public function __construct(AchievementRepository $achievementRepository)
    {
        $this->repository = $achievementRepository;
    }

    /**
     * @return array
     */
    public function getAchievementData() :array {
        try {
            $data = $this->repository->getAuthData();

            return $this->response($data)->success();
        }catch (Exception $e){

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function storeAchievementData($request) :array {
        try {
            $input = [
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description
            ];
            $this->repository->create($input);

            return $this->response()->success("Saved Successfully");
        }catch (Exception $e){

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function updateAchievementData($request) :array {
        try {
            $input = [
                'title' => $request->title,
                'description' => $request->description
            ];
            $this->repository->update($request->id, $input);

            return $this->response()->success("Updated Successfully");
        }catch (Exception $e){

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function destroyAchievementData($request){
        try {
            $this->repository->destroy($request->id);

            return $this->response()->success("Deleted");
        }catch (Exception $e){

            return $this->response()->error();
        }
    }
}
