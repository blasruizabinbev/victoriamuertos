<?php

namespace App\Bus\Command\Handler;

use App\Bus\Command\SaveProfileCommand;
use App\Entity\Profile;
use App\Repository\ProfileRepository;
use App\Service\MailService;

class ProfileHandler
{

    /**
     * @var ProfileRepository
     */
    protected $profileRepository;

    /**
     * @var MailService
     */
    protected $mailService;

    public function __construct(ProfileRepository $profileRepository, MailService $mailService)
    {
        $this->profileRepository = $profileRepository;
        $this->mailService = $mailService;
    }

    /**
     * @param SaveProfileCommand $command
     * @return mixed
     */
    public function handleSaveProfileCommand(SaveProfileCommand $command)
    {
        $profile = Profile::createFromCommand($command);
        $this->profileRepository->saveProfile($profile);

        $this->mailService->subscribeUser($command->getEmail());

        return $profile->getUuid();
    }

}