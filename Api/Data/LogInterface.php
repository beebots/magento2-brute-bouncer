<?php

namespace BeeBots\BruteBouncer\Api\Data;

/**
 * Interface LogInterface
 *
 * @package BeeBots\BruteBouncer\Api\Data
 */
interface LogInterface
{
    const ID_FIELD = 'id';
    const IP_ADDRESS_FIELD = 'ip_address';
    const RESOURCE_KEY_FIELD = 'resource_key';
    const REQUEST_COUNT_FIELD = 'request_count';
    const FIRST_REQUEST_AT_FIELD = 'first_request_at';
    const LOCKED_AT_FIELD = 'locked_at';

    /**
     * Function: getId
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Function: getIpAddress
     *
     * @return string
     */
    public function getIpAddress(): string;

    /**
     * Function: getResourceKey
     *
     * @return string
     */
    public function getResourceKey(): string;

    /**
     * Function: getRequestCount
     *
     * @return int
     */
    public function getRequestCount(): int;

    /**
     * Function: getFirstRequestAt
     *
     * @return string
     */
    public function getFirstRequestAt(): string;

    /**
     * Function: getLockedAt
     *
     * @return string
     */
    public function getLockedAt(): string;

    /**
     * Function: setId
     *
     * @return LogInterface
     */
    public function setId(): LogInterface;

    /**
     * Function: setIpAddress
     *
     * @param string $ipAddress
     *
     * @return LogInterface
     */
    public function setIpAddress(string $ipAddress): LogInterface;

    /**
     * Function: setResourceKey
     *
     * @param string $resourceKey
     *
     * @return LogInterface
     */
    public function setResourceKey(string $resourceKey): LogInterface;

    /**
     * Function: setRequestCount
     *
     * @param int $requestCount
     *
     * @return LogInterface
     */
    public function setRequestCount(int $requestCount): LogInterface;

    /**
     * Function: setFirstRequestAt
     *
     * @param string $firstRequestAt
     *
     * @return LogInterface
     */
    public function setFirstRequestAt(string $firstRequestAt): LogInterface;

    /**
     * Function: setLockedAt
     *
     * @return LogInterface
     */
    public function setLockedAt(string $lockedAt): LogInterface;
}
