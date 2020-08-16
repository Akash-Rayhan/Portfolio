<?php


namespace App\Http\Services;
use App\Http\Repository\WorkExperienceRepository;
use App\Http\Services\Boilerplate\BaseService;
use Exception;
use Illuminate\Support\Facades\Auth;

class WorkExperienceService extends BaseService
{
    /**
     * WorkExperienceService constructor.
     * @param WorkExperienceRepository $workExperienceRepository
     */
    public function __construct(WorkExperienceRepository $workExperienceRepository)
    {
        $this->repository = $workExperienceRepository;
    }

    /**
     * @return array
     */
    public function getWorkExperienceData() :array {
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
    public function storeWorkExperienceData($request) :array {
        try {
            $input = [
                'user_id' => Auth::id(),
                'company_name' => $request->company_name,
                'job_position' => $request->job_position
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
    public function updateWorkExperienceData($request) :array {
        try {
            $input = [
                'company_name' => $request->company_name,
                'job_position' => $request->job_position
            ];
            $this->repository->update($request->id, $input);

            return $this->response()->success("Updated Successfully");
        }catch (Exception $e){

            return $this->response()->error();
        }
    }
    public function destroyWorkExperienceData($request) :array {
        try {
            $this->repository->destroy($request->id);

            return $this->response()->success("Deleted");
        }catch (Exception $e){

            return $this->response()->error();
        }
    }
}
