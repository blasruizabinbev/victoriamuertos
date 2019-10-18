<?php

namespace App\Bus\Query;

use App\Entity\Profile;

class FetchProfilesCommand
{

    private $offset;
    private $limit;
    private $uuid = null;

    /**
     * FetchProfilesCommand constructor.
     * @param int $offset
     * @param int $limit
     * @param null $uuid
     */
    public function __construct($offset = 0, $limit = Profile::QUERY_DEFAULT_LIMIT, $uuid = null)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->uuid = $uuid;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return null
     */
    public function getUuid()
    {
        return $this->uuid;
    }

}