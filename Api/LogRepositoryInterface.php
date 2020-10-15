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
     * @return mixed
     */
    public function getByIpAndResource(string $ipAddress, string $resourceKey);

    /**
     * Function: save
     *
     * @param LogInterface $log
     *
     * @return LogInterface
     */
    public function save(LogInterface $log): LogInterface;
}
