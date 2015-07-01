<?php

namespace NcpFacility\Hydrator\Model;

use Doctrine\Common\Persistence\ObjectManager;
use NcpBase\Hydrator\Model\BaseHydrator;

class AddressHydrator extends BaseHydrator
{
    /**
     * @param ObjectManager $objectManager
     * @param bool $byValue
     */
    public function __construct(ObjectManager $objectManager, $byValue = true)
    {
        parent::__construct($objectManager, $byValue);
    }

}
