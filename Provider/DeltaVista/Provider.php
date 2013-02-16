<?php

namespace Astina\Bundle\SolvencyBundle\Provider\DeltaVista;

use Astina\Bundle\SolvencyBundle\Exception\SolvencyException;
use Astina\Bundle\SolvencyBundle\Provider\AddressInterface;

use Astina\Bundle\SolvencyBundle\Solvency\SolvencyResult as BaseResult;
use Astina\Bundle\SolvencyBundle\Solvency\SolvencyResult;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class Provider
{
    private $wsdlUrl;

    private $user;

    private $password;

    private $endpointUrl;

    private $location;

    private $logger;

    function __construct($wsdlUrl, $user, $password, $correlationId, $endpointUrl,
                         LoggerInterface $logger)
    {
        $this->wsdlUrl = $wsdlUrl;
        $this->user = $user;
        $this->password = $password;
        $this->correlationId = $correlationId;
        $this->endpointUrl = $endpointUrl;
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
        $client = new \SoapClient($this->wsdlUrl);

        $this->logger->info('Checking address solvency', array('address' => (string) $address));

        $ctx = $this->createContext();

        $header = new \SoapHeader('http://www.deltavista.com/dspone/ordercheck-if/V001', 'messageContext', $ctx);

        $req = $this->createRequest($address);

        $opts = array();
        if ($this->endpointUrl) {
            $opts['location'] = $this->endpointUrl;
        }

        try {
            $response = $client->__soapCall('orderCheck', array($req), $opts, array($header));
        } catch (\Exception $e) {
            throw new SolvencyException('Failed to get DeltaVista SOAP response', null, $e);
        }

        return new SolvencyResult($response);
    }

    /**
     * @param \Astina\Bundle\SolvencyBundle\Provider\AddressInterface $address
     * @return \stdClass
     */
    private function createRequest(AddressInterface $address)
    {
        $product= new \stdClass();
        $product->name = $address->getCompany() ? 'QuickCheckBusiness' : 'QuickCheckConsumer';
        $product->country = $this->correlationId;
        $product->proofOfInterest = 'ABK';

        $candidate = new \stdClass();
        $candidate->legalForm = $address->getCompany() ? 'COMPANY' : 'PERSON';
        $candidate->address = new \stdClass();
        $candidate->address->name = $address->getCompany() ?: $address->getLastName();
        $candidate->address->firstName = $address->getCompany() ? null : $address->getFirstName();
        $candidate->address->location = new \stdClass();
        $candidate->address->location->street = $address->getStreet();
        $candidate->address->location->house = null;
        $candidate->address->location->city = $address->getCity();
        $candidate->address->location->zip = $address->getZipCode();
        $candidate->address->location->country = $address->getCountry();

        $req = new \stdClass();
        $req->product = $product;
        $req->searchedCandidate = $candidate;

        return $req;
    }

    /**
     * @return \stdClass
     */
    private function createContext()
    {
        $ctx = new \stdClass();
        $ctx->credentials = new \stdClass();
        $ctx->credentials->user = $this->user;
        $ctx->credentials->password = $this->password;
        $ctx->correlationID = $this->correlationId;

        return $ctx;
    }
}
