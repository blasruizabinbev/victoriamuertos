<?php

namespace App\Event;

use Composer\EventDispatcher\Event;

class ProfileModerated extends Event
{

    private $uuid;
    private $email;
    private $modStatus;

    public function __construct($uuid, $email, $modStatus)
    {
        parent::__construct(self::class);

        $this->uuid = $uuid;
        $this->email = $email;
        $this->modStatus = $modStatus;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getModStatus()
    {
        return $this->modStatus;
    }

}