<?php
namespace BeeBots\BruteBouncer\Api;

use BeeBots\BruteBouncer\Api\Data\LogInterface;

interface LogRepositoryInterface
{
    /**
     * Function: getByIpAndResource
     *
     * @param string $ipAddress
     * @param string $resourceKey
     *
     * @return LogInterface|null
     */
    public function getByIpAndResource(string $ipAddress, string $resourceKey): ?LogInterface;

    /**
     * Function: getOrCreateByIpAndResource
     *
     * @param string $ipAddress
     * @param string $resourceKey
     *
     * @return LogInterface
     */
    public function getOrCreateByIpAndResource(string $ipAddress, string $resourceKey): LogInterface;
}
