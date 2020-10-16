<?php

namespace BeeBots\BruteBouncer\Test\Unit\Model;

use BeeBots\BruteBouncer\Api\Data\LogInterface;
use BeeBots\BruteBouncer\Model\AccessManager;
use BeeBots\BruteBouncer\Model\Config;
use BeeBots\BruteBouncer\Model\Log;
use BeeBots\BruteBouncer\Model\LogFactory;
use BeeBots\BruteBouncer\Model\LogRepository;
use DateInterval;
use DateTime;
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

    /** @var Config|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $config;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->logRepositoryMock = Mockery::mock(LogRepository::class);
        $this->logFactoryMock = Mockery::mock(LogFactory::class);
        $this->config = Mockery::mock(Config::class);
        $this->accessManager = $this->objectManager->getObject(
            AccessManager::class,
            [
                'logRepository' => $this->logRepositoryMock,
                'logFactory' => $this->logFactoryMock,
                'config' => $this->config
            ]
        );
        parent::setUp();
    }

    public function testAttemptAccessFirstTimeShouldAllow()
    {
        $this->config->shouldReceive(
            [
                'isEnabled' => true,
                'getAttemptLimit' => 5
            ]
        );
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
        $this->config->shouldReceive(
            [
                'isEnabled' => true,
                'getAttemptLimit' => 5,
                'getLockoutMinutes' => 5
            ]
        );
        $log = $this->objectManager->getObject(Log::class);
        $log->setId(1)
            ->setIpAddress('123.123.123.123')
            ->setResourceKey('somewhere_cool')
            ->setLockedAt(2145916800) // 2038/01/01
            ->setFirstRequestAt(1577836800); // 2020/01/01

        $this->logRepositoryMock->shouldReceive(
            [
                'getByIpAndResource' => $log,
                'save' => $log
            ]
        );
        $hasAccess = $this->accessManager->attemptAccess(
            '123.123.123.123',
            'somewhere_cool'
        );

        $this->assertFalse($hasAccess);
    }

    public function testAttemptAccessReachesLimitShouldNotAllow()
    {
        $this->config->shouldReceive(
            [
                'isEnabled' => true,
                'getAttemptLimit' => 5,
                'getLockoutMinutes' => 5
            ]
        );
        $log = $this->objectManager->getObject(Log::class);
        $firstAttempt = new DateTime();
        $firstAttempt->sub(new DateInterval('PT3M')); // 3 minutes ago
        $log->setId(1)
            ->setIpAddress('123.123.123.123')
            ->setResourceKey('somewhere_cool')
            ->setRequestCount(5)
            ->setLockedAt(null)
            ->setFirstRequestAt($firstAttempt->getTimestamp());

        $this->logRepositoryMock->shouldReceive(
            [
                'getByIpAndResource' => $log,
                'save' => $log
            ]
        );
        $hasAccess = $this->accessManager->attemptAccess(
            '123.123.123.123',
            'somewhere_cool'
        );

        $this->assertFalse($hasAccess);
    }

    public function testAttemptAccessModuleDisabledShouldAllow()
    {
        $this->config->shouldReceive(['isEnabled' => false]);
        $hasAccess = $this->accessManager->attemptAccess(
            '123.123.123.123',
            'somewhere_cool'
        );

        $this->assertTrue($hasAccess);
    }
}
