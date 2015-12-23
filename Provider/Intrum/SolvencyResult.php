<?php

namespace Astina\Bundle\SolvencyBundle\Provider\Intrum;

use Astina\Bundle\SolvencyBundle\Solvency\SolvencyResult as BaseResult;

class SolvencyResult extends BaseResult
{
    function __construct(\SimpleXMLElement $response)
    {
        $status = self::STATUS_UNKNOWN;

        if (!isset($response->Customer[0]->RequestStatus) || !$response->Customer[0]->RequestStatus) {
            $status = self::STATUS_BAD;
        } else {
            switch (intval($response->Customer[0]->RequestStatus)) {
                case 2 :
                    $status = self::STATUS_GOOD;
                    break;
                default :
                    $status = self::STATUS_BAD;
            }
        }
        parent::__construct($status);
    }
}
