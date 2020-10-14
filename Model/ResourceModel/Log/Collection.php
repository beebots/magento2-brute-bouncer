<?php

namespace BeeBots\BruteBouncer\Model\ResourceModel\Log;

use BeeBots\BruteBouncer\Model\Log;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package BeeBots\BruteBouncer\Model\ResourceModel\Log
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Function: _construct
     */
    protected function _construct()
    {
        $this->_init(Log::class, \BeeBots\BruteBouncer\Model\ResourceModel\Log::class);
    }
}
