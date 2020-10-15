<?php

namespace BeeBots\BruteBouncer\Model;

use BeeBots\BruteBouncer\Api\AccessManagerInterface;
use BeeBots\BruteBouncer\Api\Data\LogInterface;
use BeeBots\BruteBouncer\Api\LogRepositoryInterface;
use DateInterval;
use DateTime;
use Exception;
use Psr\Log\LoggerInterface;

/**
 * Class AccessManager
 *
 * @package BeeBots\BruteBouncer\Model
 */
class AccessManager implements AccessManagerInterface
{
    /** @var Config */
    private $config;

    /** @var LogRepositoryInterface */
    private $logRepository;

    /** @var LogFactory */
    private $logFactory;

    /** @var LoggerInterface */
    private $logger;

    /**
     * AccessManager constructor.
     *
     * @param Config $config
     * @param LogRepositoryInterface $logRepository
     * @param LogFactory $logFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Config $config,
        LogRepositoryInterface $logRepository,
        LogFactory $logFactory,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->logRepository = $logRepository;
        $this->logFactory = $logFactory;
        $this->logger = $logger;
    }

    /**
     * Function: attemptAccess
     *
     * @param string $ipAddress
     * @param string $resourceKey
     *
     * @return bool
     */
    public function attemptAccess(string $ipAddress, string $resourceKey): bool
    {
        $log = $this->getOrCreateLog($ipAddress, $resourceKey);
        if ($this->isLocked($log)) {
            return false;
        }
        $this->incrementRequestsCount($log);
        $this->applyTimeWindowRules($log);
        $this->applyLockingRules($log);
        $this->saveLog($log);
        if ($this->isLocked($log)) {
            return false;
        }

        return true;
    }

    /**
     * Function: getOrCreateLog
     *
     * @param string $ipAddress
     * @param string $resourceKey
     *
     * @return LogInterface|Log
     */
    private function getOrCreateLog(string $ipAddress, string $resourceKey)
    {
        return $this->logRepository->getByIpAndResource($ipAddress, $resourceKey)
            ?? $this->logFactory->create(
                [
                    LogInterface::IP_ADDRESS_FIELD => $ipAddress,
                    Loginterface::RESOURCE_KEY_FIELD => $resourceKey
                ]
            );
    }

    /**
     * Function: applyTimeWindowRules
     *
     * @param LogInterface $log
     */
    private function applyTimeWindowRules(LogInterface $log): void
    {
        $now = new DateTime();
        if (! $log->getFirstRequestAt()) {
            $log->setFirstRequestAt($now->getTimestamp());
            return;
        }

        try {
            $firstRequestAt = new DateTime($log->getFirstRequestAt());
            $attemptWindowInMinutes = $this->config->getAttemptWindowMinutes();
            $windowInterval = new DateInterval("PT{$attemptWindowInMinutes}M");
            // If the window has passed reset it
            if ($firstRequestAt->add($windowInterval) < $now) {
                $log->setFirstRequestAt($now->getTimestamp());
                $log->setRequestCount(1);
            }
        } catch (Exception $e) {
            $this->logger->error('Error while creating a date', ['exception' => $e]);
        }
    }

    /**
     * Function: applyLockingRules
     *
     * @param LogInterface $log
     */
    private function applyLockingRules(LogInterface $log): void
    {
        $attemptLimit = $this->config->getAttemptLimit();
        if ($log->getRequestCount() <= $attemptLimit) {
            $log->setLockedAt(null);
            return;
        }

        $now = new DateTime();
        $log->setLockedAt($now->getTimestamp());
    }

    /**
     * Function: isLocked
     *
     * @param LogInterface $log
     *
     * @return bool
     */
    private function isLocked(LogInterface $log)
    {
        $lockedAtTimeStamp = $log->getLockedAt();
        if (! $lockedAtTimeStamp) {
            return false;
        }

        try {
            $lockedAt = new DateTime();
            $lockedAt->setTimeStamp((int)$lockedAtTimeStamp);
            $lockoutDuration = $this->config->getLockoutMinutes();
            $lockDurationInterval = new DateInterval("PT{$lockoutDuration}M");
            $lockedUntil = $lockedAt->add($lockDurationInterval);

            $now = new DateTime();
            if ($lockedUntil > $now) {
                return true;
            }
        } catch (Exception $e) {
            $this->logger->error('Error while creating a date', ['exception' => $e]);
        }

        return false;
    }

    /**
     * Function: incrementRequestsCount
     *
     * @param LogInterface $log
     */
    private function incrementRequestsCount(LogInterface $log): void
    {
        $newRequestCount = $log->getRequestCount()
            ? $log->getRequestCount() + 1
            : 0;

        $log->setRequestCount($newRequestCount);
    }

    /**
     * Function: saveLog
     *
     * @param LogInterface $log
     */
    private function saveLog(LogInterface $log)
    {
        $this->logRepository->save($log);
    }
}
