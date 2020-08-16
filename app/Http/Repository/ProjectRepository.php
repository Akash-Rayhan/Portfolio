<?php


namespace App\Http\Repository;


use App\Models\Projects;

class ProjectRepository extends BaseRepository
{
    /**
     * ProjectRepository constructor.
     * @param Projects $projects
     */
    public function __construct(Projects $projects)
    {
        parent::__construct($projects);
    }
}
