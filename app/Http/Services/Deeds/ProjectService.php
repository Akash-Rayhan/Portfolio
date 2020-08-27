<?php


namespace App\Http\Services\Deeds;
use App\Http\Services\Boilerplate\BaseService;

use App\Http\Repository\ProjectRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProjectService extends BaseService
{
    /**
     * ProjectService constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->repository = $projectRepository;
    }

    /**
     * @return array
     */
    public function getProjectData() :array {
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
    public function storeProjectData($request) :array {
        try {
            $input =  array_merge(['user_id' => Auth::id()], $this->prepareToInjectData($request));
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
    public function updateProjectData($request) :array {
        try {
            $this->repository->update($request->id, $this->prepareToInjectData($request));

            return $this->response()->success("Updated Successfully");
        }catch (Exception $e){

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function destroyProjectData($request) :array {
        try {
            $this->repository->destroy($request->id);

            return $this->response()->success("Deleted");
        }catch (Exception $e){

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function prepareToInjectData($request) :array{
        return [
            'title' => $request->title,
            'status' => $request->status,
            'repo_link' => $request->repo_link
        ];
    }
}
