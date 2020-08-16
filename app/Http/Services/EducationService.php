<?php


namespace App\Http\Services;


use App\Http\Repository\EducationRepository;
use App\Http\Services\Boilerplate\BaseService;
use Exception;
use Illuminate\Support\Facades\Auth;

class EducationService extends BaseService
{
    /**
     * @var EducationRepository
     */
    public function __construct(EducationRepository $educationRepository)
    {
        $this->repository = $educationRepository;
    }

    /**
     * @return array
     */
    public function getEducationData() :array {
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
    public function storeEducationFormData($request) :array {
        try {
            $input = [
                'user_id' => Auth::id(),
                'degree' => $request->degree,
                'session' => $request->session,
                'institution' => $request->institution
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
    public function updateEducationData($request) :array {
        try {
            $input = [
                'degree' => $request->degree,
                'session' => $request->session,
                'institution' => $request->institution
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
    public function destroyEducationData($request) :array {
        try {
            $this->repository->destroy($request->id);

            return $this->response()->success("Deleted");
        }catch (Exception $e){

            return $this->response()->error();
        }
    }
}
