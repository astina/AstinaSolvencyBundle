<?php

namespace Astina\Bundle\SolvencyBundle\Provider\Intrum;

use Astina\Bundle\ShopBundle\Model\Order;
use Astina\Bundle\SolvencyBundle\Exception\SolvencyException;
use Astina\Bundle\SolvencyBundle\Provider\AddressInterface;
use Astina\Bundle\SolvencyBundle\Provider\ProviderInterface;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class Provider implements ProviderInterface
{
    private $userId;
    
    private $clientId;

    private $clientEmail;

    private $password;

    private $endpointUrl;

    private $twig;

    private $logger;

    function __construct($clientId, $clientEmail, $userId, $email, $password, $endpointUrl, TwigEngine $twig, LoggerInterface $logger)
    {
        $this->clientId = $clientId;
        $this->clientEmail = $clientEmail;
        $this->userId = $userId;
        $this->password = $password;
        $this->endpointUrl = $endpointUrl;
        $this->twig = $twig;
        $this->logger = $logger;
        $this->httpClient    = new \GuzzleHttp\Client();
    }

    /**
     * @param \Astina\Bundle\SolvencyBundle\Provider\AddressInterface $address
     * @param array $options
     * @throws \Astina\Bundle\SolvencyBundle\Exception\SolvencyException
     * @return SolvencyResult
     */
    public function checkAddress(AddressInterface $address, array $options = null)
    {
        $this->logger->info('Checking address solvency with provider Intrum', array('address' => (string) $address));

        if(!isset($options['order']) || !$options['order'] instanceof Order) {
            throw new SolvencyException('Astina\Bundle\ShopBundle\Model\Order needs to be passsed in the options');
        }

        /** @var Order $order */
        $order = $options['order'];

        $body = $this->twig->render(
            'AstinaSolvencyBundle::intrum.xml.twig',
            [
                'client_id' => $this->clientId,
                'client_email' => $this->clientEmail,
                'user_id' => $this->userId,
                'password' => $this->password,
                'request_id' => uniqid(),
                'address' => $address,
                'order' => $order,
                'order_closed' => $order->isStatusFulfilled() ? 'YES' : 'NO',
            ]
        );

        $form_params = ['request' => $body];

        $requestOptions = [
            'form_params' => $form_params
        ];

        try{
            $res = $this->httpClient->request(
                'POST',
                $this->endpointUrl,
                $requestOptions
            );
        } catch(RequestException $e) {
            throw new SolvencyException('Failed to get Intrum response', null, $e);
        }

        $responseContent = "";
        try{
            $responseContent = $res->getBody()->getContents();
            $responseXml = new \SimpleXMLElement($responseContent);
        } catch(\Exception $e) {
            throw new SolvencyException('Could not parse Intrum response xml', null, $e);
        } finally {
            $this->logger->info('Received Intrum response', array('response' => (string) $responseContent));
        }
        return new SolvencyResult($responseXml);
    }
}
