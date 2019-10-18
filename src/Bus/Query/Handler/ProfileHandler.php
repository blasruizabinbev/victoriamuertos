<?php

namespace App\Bus\Query\Handler;

use App\Bus\Query\FetchProfilesCommand;
use App\DTO\FetchProfilesResult;
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
     * @param FetchProfilesCommand $command
     * @return mixed
     */
    public function handleFetchProfilesCommand(FetchProfilesCommand $command)
    {
        $result = $this->profileRepository->findWithOffer(
            $command->getUuid() && $command->getOffset() > 0 ? $command->getOffset() - 1 : $command->getOffset(),
            $command->getLimit()
        );
        if($command->getUuid()) {
            $result = array_filter($result, function($profile) use ($command) {
                /** @var Profile $profile */
                return $profile->getUuid() !== $command->getUuid();
            });
            if($command->getOffset() === 0) {
                $profile = $this->profileRepository->find($command->getUuid());
                if($profile) {
                    $result = array_merge([$profile], $result);
                }
            }
        }
        return new FetchProfilesResult(
            $result,
            $command->getOffset(),
            $command->getLimit(),
            $this->profileRepository->findMax()
        );
    }

}