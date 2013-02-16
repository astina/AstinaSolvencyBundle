<?php

namespace Astina\Bundle\SolvencyBundle\Provider\DeltaVista;

use Astina\Bundle\SolvencyBundle\Solvency\SolvencyResult as BaseResult;

class SolvencyResult extends BaseResult
{
    function __construct(\stdClass$response)
    {
        $status = self::STATUS_UNKNOWN;

        if ($response->returnCode != '0') {
            $status = self::STATUS_BAD;
        } else {
            switch ($response->myDecision->decision) {
                case 'RED' :
                    $status = self::STATUS_BAD;
                    break;
                case 'YELLOW' :
                    $status = self::STATUS_MEDIUM;
                    break;
                case 'GREEN' :
                    $status = self::STATUS_GOOD;
                    break;
            }
        }

        parent::__construct($status);
    }

}
