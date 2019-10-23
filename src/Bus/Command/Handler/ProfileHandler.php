<?php

namespace App\Bus\Command\Handler;

use App\Bus\Command\SaveProfileCommand;
use App\Entity\Profile;
use App\Repository\ProfileRepository;
use App\Service\ImageService;

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

    public function __construct(ProfileRepository $profileRepository, ImageService $imageService)
    {
        $this->profileRepository = $profileRepository;
        $this->imageService = $imageService;
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

        return $profile->getUuid();
    }

}