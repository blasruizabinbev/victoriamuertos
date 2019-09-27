<?php

namespace App\Bus\Command\Handler;

use App\Bus\Command\SaveProfileCommand;
use App\Entity\Profile;
use App\Repository\ProfileRepository;

class ProfileHandler
{

    /**
     * @var ProfileRepository
     */
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * @param SaveProfileCommand $command
     * @return mixed
     */
    public function handleSaveProfileCommand(SaveProfileCommand $command)
    {
        $profile = Profile::createFromCommand($command);
        $this->profileRepository->saveProfile($profile);
        return $profile->getUuid();
    }

}