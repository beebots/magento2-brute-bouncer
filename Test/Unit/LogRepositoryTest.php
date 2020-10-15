<?php

namespace BeeBots\BruteBouncer\Test\Unit;

use BeeBots\BruteBouncer\Model\Log;
use BeeBots\BruteBouncer\Model\LogRepository;
use BeeBots\BruteBouncer\Model\ResourceModel\Log\Collection;
use BeeBots\BruteBouncer\Model\ResourceModel\Log\CollectionFactory;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Mockery;
use PHPUnit\Framework\TestCase;

class LogRepositoryTest extends TestCase
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var CollectionFactory|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $logCollectionFactoryMock;

    /** @var Collection|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $logCollectionMock;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        $this->logCollectionFactoryMock = Mockery::mock(CollectionFactory::class);
        $this->logCollectionMock = Mockery::mock(Collection::class);

        parent::setUp();
    }

    public function testGetByIpAndResource()
    {
        $logRepository = $this->objectManager->getObject(
            LogRepository::class,
            [
                'collectionFactory' => $this->logCollectionFactoryMock
            ]
        );
        $ipAddress = '123.123.123.123';
        $resourceKey = 'somewhere_cool';
        $logItem = $this->objectManager->getObject(
            Log::class,
            [
                'ipAddress' => $ipAddress,
                'resourceKey' => $resourceKey
            ]
        );
        $this->logCollectionFactoryMock->shouldReceive(['create' => $this->logCollectionMock]);
        $this->logCollectionMock->shouldReceive(
            [
                'getFirstItem' => $logItem,
                'addFieldToFilter' => $this->logCollectionMock
            ]
        );
        $result = $logRepository->getByIpAndResource(
            $ipAddress,
            $resourceKey
        );

        $this->assertEquals($logItem, $result);
    }
}
