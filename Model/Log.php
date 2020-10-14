<?php

namespace BeeBots\BruteBouncer\Model;

use BeeBots\BruteBouncer\Api\Data\LogInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Log
 *
 * @package BeeBots\BruteBouncer\Model
 */
class Log extends AbstractModel implements
    LogInterface,
    IdentityInterface
{
    /**
     *
     */
    const CACHE_TAG = 'beebots_brutebouncer_log';

    /** @var string */
    protected $_cacheTag = 'beebots_brutebouncer_log';

    /** @var string */
    protected $_eventPrefix = 'beebots_brutebouncer_log';

    /**
     * Function: _construct
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Log::class);
    }

    /**
     * Function: getIdentities
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Function: getIpAddress
     *
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->getData(LogInterface::IP_ADDRESS_FIELD);
    }

    /**
     * Function: getResourceKey
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return $this->getData(LogInterface::RESOURCE_KEY_FIELD);
    }

    /**
     * Function: getRequestCount
     *
     * @return int
     */
    public function getRequestCount(): int
    {
        return (int)$this->getData(LogInterface::REQUEST_COUNT_FIELD);
    }

    /**
     * Function: getFirstRequestAt
     *
     * @return string
     */
    public function getFirstRequestAt(): string
    {
        return $this->getData(LogInterface::FIRST_REQUEST_AT_FIELD);
    }

    /**
     * Function: getLockedAt
     *
     * @return string
     */
    public function getLockedAt(): string
    {
        return $this->getData(LogInterface::LOCKED_AT_FIELD);
    }

    /**
     * Function: setIpAddress
     *
     * @param string $ipAddress
     *
     * @return LogInterface
     */
    public function setIpAddress(string $ipAddress): LogInterface
    {
        return $this->setData(LogInterface::IP_ADDRESS_FIELD, $ipAddress);
    }

    /**
     * Function: setResourceKey
     *
     * @param string $resourceKey
     *
     * @return LogInterface
     */
    public function setResourceKey(string $resourceKey): LogInterface
    {
        return $this->setData(LogInterface::RESOURCE_KEY_FIELD, $resourceKey);
    }

    /**
     * Function: setRequestCount
     *
     * @param int $requestCount
     *
     * @return LogInterface
     */
    public function setRequestCount(int $requestCount): LogInterface
    {
        return $this->setData(LogInterface::REQUEST_COUNT_FIELD, $requestCount);
    }

    /**
     * Function: setFirstRequestAt
     *
     * @param string $firstRequestAt
     *
     * @return LogInterface
     */
    public function setFirstRequestAt(string $firstRequestAt): LogInterface
    {
        return $this->setData(LogInterface::FIRST_REQUEST_AT_FIELD, $firstRequestAt);
    }

    /**
     * Function: setLockedAt
     *
     * @param string $lockedAt
     *
     * @return LogInterface
     */
    public function setLockedAt(string $lockedAt): LogInterface
    {
        return $this->setData(LogInterface::LOCKED_AT_FIELD, $lockedAt);
    }
}
