<?php


namespace App\Http\Repository;


use App\Models\Achievements;

class AchievementRepository extends BaseRepository
{
    /**
     * AchievementRepository constructor.
     * @param Achievements $achievements
     */
    public function __construct(Achievements $achievements)
    {
        parent::__construct($achievements);
    }
}
