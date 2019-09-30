<?php

namespace App\Controller\Api;

use App\Bus\Command\SaveProfileCommand;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProfileController
{

    /** @var CommandBus */
    protected $commandBus;

    /** @var LoggerInterface */
    protected $logger;

    public function __construct(CommandBus $commandBus, LoggerInterface $logger)
    {

        $this->commandBus = $commandBus;
        $this->logger = $logger;
    }

    public function saveProfile(Request $request)
    {
        $uuid = $this->commandBus->handle(
            new SaveProfileCommand(
                $request->get('firstName'),
                $request->get('lastName'),
                $request->get('email'),
                $request->get('dateOfBirth'),
                $request->get('question1'),
                $request->get('question2'),
                $request->get('question3'),
                boolval($request->get('acceptTerms'))
            )
        );

        return [
            'uuid' => $uuid
        ];
    }

}