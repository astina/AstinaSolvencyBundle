<?php

namespace Astina\Bundle\SolvencyBundle\Provider;

use Astina\Bundle\SolvencyBundle\Solvency\SolvencyResult;

interface ProviderInterface
{
    /**
     * @param AddressInterface $address
     * @return SolvencyResult
     */
    public function checkAddress(AddressInterface $address);
}
