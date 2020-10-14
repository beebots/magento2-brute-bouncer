<?php

namespace BeeBots\BruteBouncer\Model;

use BeeBots\BruteBouncer\Api\Data\LogInterface;
use BeeBots\BruteBouncer\Api\LogRepositoryInterface;
use BeeBots\BruteBouncer\Model\LogFactory;
use BeeBots\BruteBouncer\Model\ResourceModel\Log\CollectionFactory;

/**
 * Class LogRepository
 *
 * @package BeeBots\BruteBouncer\Model
 */
class LogRepository implements LogRepositoryInterface
{
    /** @var CollectionFactory */
    private $collectionFactory;

    /** @var \BeeBots\BruteBouncer\Model\LogFactory */
    private $logFactory;

    /**
     * AccessManager constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param LogFactory $logFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        LogFactory $logFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->logFactory = $logFactory;
    }

    /**
     * Function: getByIpAndResource
     *
     * @param string $ipAddress
     * @param string $resourceKey
     *
     * @return LogInterface|null
     */
    public function getByIpAndResource(string $ipAddress, string $resourceKey): ?LogInterface
    {
        /** @var ResourceModel\Log\Collection $logCollection */
        $logCollection = $this->collectionFactory->create();
        return $logCollection->addFieldToFilter(LogInterface::ID_FIELD, $ipAddress)
            ->addFieldToFilter(LogInterface::RESOURCE_KEY_FIELD, $resourceKey)
            ->getFirstItem();
    }

    /**
     * Function: getOrCreateByIpAndResource
     *
     * @param string $ipAddress
     * @param string $resourceKey
     *
     * @return LogInterface
     */
    public function getOrCreateByIpAndResource(string $ipAddress, string $resourceKey): LogInterface
    {
        $log = $this->getByIpAndResource($ipAddress, $resourceKey);
        if (! $log) {
            /** @var LogInterface $log */
            $log = $this->logFactory->create();
            $log->setId($ipAddress);
            $log->setResourceKey($resourceKey);
        }
    }
}
