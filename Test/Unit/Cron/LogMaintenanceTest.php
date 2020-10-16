<?php

namespace BeeBots\BruteBouncer\Test\Unit\Cron;

use BeeBots\BruteBouncer\Api\LogRepositoryInterface;
use BeeBots\BruteBouncer\Cron\LogMaintenance;
use BeeBots\BruteBouncer\Model\Config;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Mockery;
use PHPUnit\Framework\TestCase;

class LogMaintenanceTest extends TestCase
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var Config|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $configMock;

    /** @var LogRepositoryInterface|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $repositoryMock;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->configMock = Mockery::mock(Config::class);
        $this->repositoryMock = Mockery::mock(LogRepositoryInterface::class);
        parent::setUp();
    }

    public function testExecuteStopsWhenDisabled()
    {
        $this->configMock->shouldReceive(
            [
                'isEnabled' => false
            ]
        );

        $this->repositoryMock->shouldNotHaveReceived('deleteOldLogs');

        $logMaintenance = $this->objectManager->getObject(
            LogMaintenance::class,
            [
                'repository' => $this->repositoryMock,
                'config' => $this->configMock
            ]
        );

        $logMaintenance->execute();
        $this->assertTrue(true); // See expectations above
    }
}
