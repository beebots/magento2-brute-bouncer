<?php

namespace BeeBots\BruteBouncer\Model;

use BeeBots\BruteBouncer\Api\Data\LogInterface;
use BeeBots\BruteBouncer\Api\LogRepositoryInterface;
use BeeBots\BruteBouncer\Model\ResourceModel\Log as LogResourceModel;
use BeeBots\BruteBouncer\Model\ResourceModel\Log\CollectionFactory;
use DateTime;
use DateInterval;
use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\DateTime as CoreDateTime;
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

    /** @var Config */
    private $config;

    /** @var LoggerInterface */
    private $logger;

    /** @var CoreDateTime */
    private $coreDate;

    /**
     * AccessManager constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param LogResourceModel $logResourceModel
     * @param Config $config
     * @param CoreDateTime $coreDate
     * @param LoggerInterface $logger
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        LogResourceModel $logResourceModel,
        Config $config,
        CoreDateTime $coreDate,
        LoggerInterface $logger
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->logResourceModel = $logResourceModel;
        $this->config = $config;
        $this->logger = $logger;
        $this->coreDate = $coreDate;
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
        $logCollection = $this->collectionFactory->create();
        $log = $logCollection->addFieldToFilter(LogInterface::IP_ADDRESS_FIELD, $ipAddress)
            ->addFieldToFilter(LogInterface::RESOURCE_KEY_FIELD, $resourceKey)
            ->getFirstItem();
        return $log;
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
            $this->logResourceModel->save($log);
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

    /**
     * Function: deleteOldLogs
     *
     * @throws LocalizedException
     */
    public function deleteOldLogs(): void
    {
        $logLifetimeDays = $this->config->getLogLifetimeDays();
        $olderThan = new DateTime();
        $olderThan->sub(new DateInterval("P{$logLifetimeDays}D"));
        $olderThanDateString = $this->coreDate->gmtDate(null, $olderThan);

        $this->logResourceModel->getConnection()->delete(
            $this->logResourceModel->getMainTable(),
            [ LogInterface::FIRST_REQUEST_AT_FIELD . ' < ?' => $olderThanDateString]
        );
    }
}
