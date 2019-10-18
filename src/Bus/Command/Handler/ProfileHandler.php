<?php

namespace App\Bus\Command\Handler;

use App\Bus\Command\SaveProfileCommand;
use App\Entity\Profile;
use App\Repository\ProfileRepository;
use App\Service\ImageService;
use App\Service\MailService;

class ProfileHandler
{

    /**
     * @var ProfileRepository
     */
    protected $profileRepository;

    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * @var MailService
     */
    protected $mailService;

    public function __construct(ProfileRepository $profileRepository, ImageService $imageService, MailService $mailService)
    {
        $this->profileRepository = $profileRepository;
        $this->imageService = $imageService;
        $this->mailService = $mailService;
    }

    /**
     * @param SaveProfileCommand $command
     * @return mixed
     */
    public function handleSaveProfileCommand(SaveProfileCommand $command)
    {
        $profile = Profile::createFromCommand($command);

        $fileName = $this->imageService->store($command->getImage(), true, $profile->getOfferVariation());
        $profile->setImage($fileName);

        $this->profileRepository->saveProfile($profile);

        $this->mailService->subscribeUser($profile);

        return $profile->getUuid();
    }

}