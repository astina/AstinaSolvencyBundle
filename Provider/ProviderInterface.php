<?php

namespace Astina\Bundle\SolvencyBundle\Provider;

use Astina\Bundle\SolvencyBundle\Solvency\SolvencyResult;

interface ProviderInterface
{
    /**
     * @param AddressInterface $address
     * @param array $options
     * @return SolvencyResult
     */
    public function checkAddress(AddressInterface $address, array $options = null);
}
