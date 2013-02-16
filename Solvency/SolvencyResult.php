<?php

namespace Astina\Bundle\SolvencyBundle\Solvency;

class SolvencyResult
{
    private $status;

    const STATUS_UNKNOWN = 'unknown';
    const STATUS_BAD = 'bad';
    const STATUS_MEDIUM = 'medium';
    const STATUS_GOOD = 'good';

    function __construct($status = null)
    {
        $this->status = $status ?: self::STATUS_UNKNOWN;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function isUnknown()
    {
        return $this->status == self::STATUS_UNKNOWN;
    }

    public function isBad()
    {
        return $this->status == self::STATUS_BAD;
    }

    public function isMedium()
    {
        return $this->status == self::STATUS_MEDIUM;
    }

    public function isGood()
    {
        return $this->status == self::STATUS_GOOD;
    }
}
