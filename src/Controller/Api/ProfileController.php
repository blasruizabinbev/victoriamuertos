<?php

namespace App\Controller\Api;

use App\Bus\Command\SaveProfileCommand;
use App\Bus\Query\FetchProfilesCommand;
use App\DTO\FetchProfilesResult;
use App\Entity\Profile;
use App\Service\TransformerManager;
use App\Transformer\ProfileTransformer;
use League\Tactician\CommandBus;
use MediaMonks\RestApi\Response\OffsetPaginatedResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProfileController
{

    /** @var CommandBus */
    protected $commandBus;

    /** @var CommandBus */
    private $queryBus;

    /** @var TransformerManager */
    private $transformerManager;

    /** @var LoggerInterface */
    protected $logger;

    public function __construct(CommandBus $commandBus, CommandBus $queryBus, TransformerManager $transformerManager, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->transformerManager = $transformerManager;
        $this->logger = $logger;
    }

    public function getProfiles(Request $request)
    {
        $offset = $request->query->getInt('offset', 0);
        $limit = $request->query->getInt('limit', Profile::QUERY_DEFAULT_LIMIT);

        /** @var FetchProfilesResult $result */
        $dto = $this->queryBus->handle(
            new FetchProfilesCommand($offset, $limit, $request->get('uuid', null))
        );

        return new OffsetPaginatedResponse(
            $this->transformerManager->transformCollection($dto->getResult(), ProfileTransformer::class),
            $dto->getOffset(),
            $dto->getLimit(),
            $dto->getMax()
        );
    }

    public function saveProfile(Request $request)
    {
        $uuid = $this->commandBus->handle(
            new SaveProfileCommand(
                $request->get('firstName'),
                $request->get('lastName'),
                $request->get('email'),
                $request->get('dateOfBirth'),
                $request->get('offerName'),
                preg_replace('#data:image/[^;]+;base64,#', '', $request->get('image')),
                boolval($request->get('acceptTerms')),
                boolval($request->get('acceptCommercial'))
            )
        );

        return [
            'uuid' => $uuid
        ];
    }

}