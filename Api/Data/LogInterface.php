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
     * @return mixed`
     */
    public function getId();

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
     * @return mixed
     */
    public function getRequestCount();

    /**
     * Function: getFirstRequestAt
     *
     * @return mixed
     */
    public function getFirstRequestAt();

    /**
     * Function: getLockedAt
     *
     * @return mixed
     */
    public function getLockedAt();

    /**
     * Function: setId
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function setId(mixed $value);

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
     * @param mixed $firstRequestAt
     *
     * @return LogInterface
     */
    public function setFirstRequestAt($firstRequestAt): LogInterface;

    /**
     * Function: setLockedAt
     *
     * @param mixed $lockedAt
     *
     * @return LogInterface
     */
    public function setLockedAt($lockedAt): LogInterface;
}
