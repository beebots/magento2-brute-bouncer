<?php

namespace BeeBots\BruteBouncer\Model\ResourceModel;

use BeeBots\BruteBouncer\Api\Data\LogInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Log
 *
 * @package BeeBots\BruteBouncer\Model\ResourceModel
 */
class Log extends AbstractDb
{
    const TABLE_NAME = 'beebots_brute_bouncer_log';

    /**
     * Function: _construct
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, LogInterface::ID_FIELD);
    }
}
