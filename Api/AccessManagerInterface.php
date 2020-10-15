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
}
