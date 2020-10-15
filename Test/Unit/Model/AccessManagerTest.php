<?php

namespace BeeBots\BruteBouncer\Test\Unit\Model;

use BeeBots\BruteBouncer\Api\Data\LogInterface;
use BeeBots\BruteBouncer\Model\AccessManager;
use BeeBots\BruteBouncer\Model\Log;
use BeeBots\BruteBouncer\Model\LogFactory;
use BeeBots\BruteBouncer\Model\LogRepository;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Mockery;
use PHPUnit\Framework\TestCase;

class AccessManagerTest extends TestCase
{
    /** @var AccessManager  */
    private $accessManager;

    /** @var ObjectManager */
    private $objectManager;

    /** @var LogFactory|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $logFactoryMock;

    /** @var LogRepository|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $logRepositoryMock;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->logRepositoryMock = Mockery::mock(LogRepository::class);
        $this->logFactoryMock = Mockery::mock(LogFactory::class);
        $this->accessManager = $this->objectManager->getObject(
            AccessManager::class,
            [
                'logRepository' => $this->logRepositoryMock,
                'logFactory' => $this->logFactoryMock
            ]
        );
        parent::setUp();
    }

    public function testAttemptAccessFirstTimeShouldAllow()
    {
        $log = $this->objectManager->getObject(
            Log::class,
            [
                LogInterface::IP_ADDRESS_FIELD => '123.123.123.123',
                LogInterface::RESOURCE_KEY_FIELD => 'somewhere_cool'
            ]
        );

        $this->logRepositoryMock->shouldReceive(
            [
                'getByIpAndResource' => null, // Not in the DB
                'save' => $log
            ]
        );
        $this->logFactoryMock->shouldReceive(['create' => $log]);
        $hasAccess = $this->accessManager->attemptAccess(
            '123.123.123.123',
            'somewhere_cool'
        );

        $this->assertTrue($hasAccess);
    }

    public function testAttemptAccessLockedLogShouldNotAllow()
    {
        $log = $this->objectManager->getObject(Log::class);
        $log->setId(1)
            ->setIpAddress('123.123.123.123')
            ->setResourceKey('somewhere_cool')
            ->setLockedAt(2145916800) // 2038/01/01
            ->setFirstRequestAt(1577836800); // 2020/01/01

        $this->logRepositoryMock->shouldReceive(['getByIpAndResource' => $log]);
        $hasAccess = $this->accessManager->attemptAccess(
            '123.123.123.123',
            'somewhere_cool'
        );

        $this->assertFalse($hasAccess);
    }
}
