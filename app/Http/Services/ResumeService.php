<?php


namespace App\Http\Services;
use App\Http\Repository\ResumeRepository;
use App\Http\Services\Boilerplate\BaseService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResumeService extends BaseService
{
    /**
     * ResumeService constructor.
     * @param ResumeRepository $resumeRepository
     */
    public function __construct(ResumeRepository $resumeRepository)
    {
        $this->repository = $resumeRepository;
    }

    /**
     * @return array
     */
    public function getResumeData() :array {
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
    public function storeResumeData($request) :array {
        try {
            $input = [
                'user_id' => Auth::id(),
                'title' => $request->title,
                'file_name' => uploadFile($request->file, userResumePath())
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
    public function destroyResumeData($request) :array {
        try {
            DB::beginTransaction();
            $deleteResponse = deleteFile(userResumePath(), $request->file_name);
            $this->repository->destroy($request->id);
            if ($deleteResponse){
                DB::commit();
            }

            return $this->response()->success("Deleted");
        }catch (Exception $e){
            DB::rollBack();

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @return array|bool
     */
    public function downloadResumeFile($request){
        try {
            $response = downloadFile(userResumePath(), $request->file_name);
            if (!$response){
                return $this->response()->error();
            }
            else{
                return $response;
            }
        }catch (Exception $e){

            return $this->response()->error();
        }
    }
}
