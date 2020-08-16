<?php


namespace App\Http\Repository;


use App\Models\Resume;

class ResumeRepository extends BaseRepository
{
    /**
     * ResumeRepository constructor.
     * @param Resume $resume
     */
    public function __construct(Resume $resume)
    {
        parent::__construct($resume);
    }
}
