<?php


namespace App\Http\Repository;


use App\Models\Educations;

class EducationRepository extends BaseRepository
{
    /**
     * EducationRepository constructor.
     * @param Educations $educations
     */
    public function __construct(Educations $educations)
    {
        parent::__construct($educations);
    }


}
