<?php

namespace BeeBots\BruteBouncer\Cron;

use BeeBots\BruteBouncer\Api\LogRepositoryInterface;
use BeeBots\BruteBouncer\Model\Config;

/**
 * Class LogMaintenance
 *
 * @package BeeBots\BruteBouncer\Cron
 */
class LogMaintenance
{
    /** @var LogRepositoryInterface */
    private $repository;

    /** @var Config */
    private $config;

    /**
     * LogMaintenance constructor.
     *
     * @param LogRepositoryInterface $repository
     * @param Config $config
     */
    public function __construct(
        LogRepositoryInterface $repository,
        Config $config
    ) {
        $this->repository = $repository;
        $this->config = $config;
    }

    /**
     * Function: execute
     */
    public function execute()
    {
        if (! $this->config->isEnabled()) {
            return $this;
        }
        $this->repository->deleteOldLogs();
        return $this;
    }
}
