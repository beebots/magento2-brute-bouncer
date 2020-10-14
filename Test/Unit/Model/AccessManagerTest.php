<?php

namespace BeeBots\BruteBouncer\Test\Unit\Model;

use BeeBots\BruteBouncer\Model\AccessManager;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Mockery;
use PHPUnit\Framework\TestCase;


class AccessManagerTest extends TestCase
{
    /** @var AccessManager  */
    private $accessManager;

    /** @var ObjectManager */
    private $objectManager;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->accessManager = $this->objectManager->getObject(AccessManager::class);
        parent::setUp();
    }

    public function testAttemptAccess()
    {
        $result = $this->accessManager->attemptAccess(
            '123.123.123.123',
            'apply_coupon'
        );

        $this->assertTrue($result);
    }

    public function testCheckAccess()
    {
        $result = $this->accessManager->attemptAccess(
            '123.123.123.123',
            'apply_coupon'
        );

        $this->assertTrue($result);
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}
