<?php

namespace Astina\Bundle\SolvencyBundle\Provider\Mock;

use Astina\Bundle\SolvencyBundle\Provider\AddressInterface;
use Astina\Bundle\SolvencyBundle\Provider\ProviderInterface;
use Astina\Bundle\SolvencyBundle\Solvency\SolvencyResult;

class Provider implements ProviderInterface
{
    private $status;

    function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * @param AddressInterface $address
     * @return SolvencyResult
     */
    public function checkAddress(AddressInterface $address)
    {
        return new SolvencyResult($this->status);
    }
}
