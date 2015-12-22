<?php

namespace Astina\Bundle\SolvencyBundle\Provider\Intrum;

use Astina\Bundle\SolvencyBundle\Exception\SolvencyException;
use Astina\Bundle\SolvencyBundle\Provider\AddressInterface;
use Astina\Bundle\SolvencyBundle\Provider\ProviderInterface;

use Symfony\Component\HttpKernel\Log\LoggerInterface;

class Provider implements ProviderInterface
{
    private $url;

    private $userId;
    
    private $clientId;

    private $password;

    private $endpointUrl;

    private $location;

    private $logger;

    function __construct($url, $userId, $clientId, $password, $correlationId,
                         LoggerInterface $logger)
    {
        $this->url = $url;
        $this->userId = $userId;
        $this->clientId = $clientId;
        $this->password = $password;
        $this->correlationId = $correlationId;
        $this->logger = $logger;
    }

    /**
     * @param \Astina\Bundle\SolvencyBundle\Provider\AddressInterface $address
     * @param array $options
     * @throws \Astina\Bundle\SolvencyBundle\Exception\SolvencyException
     * @return SolvencyResult
     */
    public function checkAddress(AddressInterface $address, array $options = null)
    {
        //
    }
}
