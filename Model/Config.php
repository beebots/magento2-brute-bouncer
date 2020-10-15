<?php

namespace BeeBots\BruteBouncer\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 *
 * @package BeeBots\BruteBouncer\Model
 */
class Config
{
    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /**
     * LayoutProcessor constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Function: isEnabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag('beebots/brute_bouncer/enabled');
    }

    /**
     * Function: getAttemptLimit
     *
     * @return int
     */
    public function getAttemptLimit(): int
    {
        return (int) $this->scopeConfig->getValue('beebots/brute_bouncer/attempt_limit');
    }

    /**
     * Function: getAttemptWindowMinutes
     *
     * @return int
     */
    public function getAttemptWindowMinutes(): int
    {
        return (int) $this->scopeConfig->getValue('beebots/brute_bouncer/attempt_window_minutes');
    }

    /**
     * Function: getLockoutMinute
     *
     * @return int
     */
    public function getLockoutMinutes(): int
    {
        return (int) $this->scopeConfig->getValue('beebots/brute_bouncer/lockout_minutes');
    }
}
