<?php

namespace BeeBots\BruteBouncer\Model;

use BeeBots\BruteBouncer\Api\Data\LogInterface;
use BeeBots\BruteBouncer\Api\LogRepositoryInterface;
use BeeBots\BruteBouncer\Model\ResourceModel\Log as LogResourceModel;
use BeeBots\BruteBouncer\Model\ResourceModel\Log\CollectionFactory;
use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Psr\Log\LoggerInterface;

/**
 * Class LogRepository
 *
 * @package BeeBots\BruteBouncer\Model
 */
class LogRepository implements LogRepositoryInterface
{
    /** @var CollectionFactory */
    private $collectionFactory;

    /** @var LogResourceModel */
    private $logResourceModel;

    /** @var LoggerInterface */
    private $logger;

    /**
     * AccessManager constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param LogResourceModel $logResourceModel
     * @param LoggerInterface $logger
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        LogResourceModel $logResourceModel,
        LoggerInterface $logger
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->logResourceModel = $logResourceModel;
        $this->logger = $logger;
    }

    /**
     * Function: getByIpAndResource
     *
     * @param string $ipAddress
     * @param string $resourceKey
     *
     * @return mixed
     */
    public function getByIpAndResource(string $ipAddress, string $resourceKey)
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter(LogInterface::ID_FIELD, $ipAddress)
            ->addFieldToFilter(LogInterface::RESOURCE_KEY_FIELD, $resourceKey)
            ->getFirstItem();
    }

    /**
     * Function: save
     *
     * @param LogInterface $log
     *
     * @return LogInterface
     */
    public function save(LogInterface $log): LogInterface
    {
        try {
            /** @noinspection PhpParamsInspection */
            $log = $this->logResourceModel->save($log);
        } catch (AlreadyExistsException $e) {
            $this->logger->error(
                "AlreadyExistsException while saving BruteBouncer log with "
                    . "ip_address: {$log->getIpAddress()} "
                    . "and resource_key: {$log->getResourceKey()}",
                [ 'exception' => $e ]
            );
        } catch (Exception $e) {
            $this->logger->error(
                "Exception while saving BruteBouncer log with "
                    . "ip_address: {$log->getIpAddress()} and "
                    . "resource_key: {$log->getResourceKey()}",
                [ 'exception' => $e ]
            );
        }

        return $log;
    }
}
