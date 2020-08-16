<?php


namespace App\Http\Repository;


use App\Models\WorkExperiences;

class WorkExperienceRepository extends BaseRepository
{
    /**
     * WorkExperienceRepository constructor.
     * @param WorkExperiences $workExperiences
     */
    public function __construct(WorkExperiences $workExperiences)
    {
        parent::__construct($workExperiences);
    }
}
