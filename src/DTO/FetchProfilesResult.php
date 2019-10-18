<?php

namespace App\DTO;

class FetchProfilesResult
{

    /**
     * @var array
     */
    private $result;
    /**
     * @var int
     */
    private $offset;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $max;

    public function __construct(array $result = [], $offset = 0, $limit = 0, $max = 0)
    {
        $this->result = $result;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->max = $max;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->result;
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
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

}