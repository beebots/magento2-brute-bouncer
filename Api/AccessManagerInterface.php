<?php


namespace BeeBots\BruteBouncer\Api;


interface AccessManagerInterface
{
    /**
     * Record an access attempt and return the result of that attempt
     *
     * @param string $ipAddress
     * @param string $resourceKey
     *
     * @return bool
     */
    public function attemptAccess(string $ipAddress, string $resourceKey): bool;

    /**
     * Don't record and access attempt, only check if access is allowed
     *
     * @param string $ipAddress
     * @param string $resourceKey
     *
     * @return bool
     */
    public function checkAccess(string $ipAddress, string $resourceKey): bool;
}
