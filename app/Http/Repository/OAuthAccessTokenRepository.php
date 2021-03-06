<?php


namespace App\Http\Repository;


use App\Models\OAuthAccessToken;

class OAuthAccessTokenRepository extends BaseRepository {

    /**
     * OAuthAccessTokenRepository constructor.
     * @param OAuthAccessToken $model
     */
    public function __construct(OAuthAccessToken $model) {
        parent::__construct($model);
    }

}
