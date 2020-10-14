<?php

namespace BeeBots\BruteBouncer\Model;

use BeeBots\BruteBouncer\Api\AccessManagerInterface;
use BeeBots\BruteBouncer\Api\LogRepositoryInterface;

/**
 * Class AccessManager
 *
 * @package BeeBots\BruteBouncer\Model
 */
class AccessManager implements AccessManagerInterface
{
    /** @var LogRepositoryInterface */
    private $logRepository;

    /**
     * AccessManager constructor.
     *
     * @param LogRepositoryInterface $logRepository
     */
    public function __construct(
        LogRepositoryInterface $logRepository
    ) {
        $this->logRepository = $logRepository;
    }

    /**
     * {inheritDoc}
     */
    public function attemptAccess(string $ipAddress, string $resourceKey): bool
    {
        $log = $this->logRepository->getOrCreateByIpAndResource($ipAddress, $resourceKey);

        // Increment the request count
        $log->setRequestCount($log->getRequestCount() + 1);

        return true;
    }

    /**
     * {inheritDoc}
     */
    public function checkAccess(string $ipAddress, string $resourceKey): bool
    {
        // TODO: Implement checkAccess() method.
        return true;
    }

    private function getAccessIsAllowed()
    {
        // TODO: Implement getAccessIsAllowed() method.
        return true;
    }
}
