<?php

namespace BeeBots\BruteBouncer\Test\Unit;

use BeeBots\BruteBouncer\Model\LogRepository;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Mockery;
use PHPUnit\Framework\TestCase;


class LogRepositoryTest extends TestCase
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var LogRepository */
    private $logRepository;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->logRepository = $this->objectManager->getObject(LogRepository::class);
        parent::setUp();
    }
    public function testGetOrCreateByIpAndResource()
    {
        $result = $this->logRepository->getOrCreateByIpAndResource(
            '123.123.123.123',
            'somewhere_cool'
        );

        $this->assertNotNull($result);
    }

    public function testGetByIpAndResource()
    {

    }
}
