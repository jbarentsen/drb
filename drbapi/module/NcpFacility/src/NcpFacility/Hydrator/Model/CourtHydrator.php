<?php

namespace NcpFacility\Hydrator\Model;

use Doctrine\Common\Persistence\ObjectManager;
use NcpBase\Hydrator\Model\BaseHydrator;
use NcpFacility\Hydrator\Filter\Court\CourtHydratorFilter;

class CourtHydrator extends BaseHydrator
{
    /**
     * @param ObjectManager $objectManager
     * @param bool $byValue
     */

    public function __construct(ObjectManager $objectManager, $byValue = true)
    {
        parent::__construct($objectManager, $byValue);

        $this->addFilter('main', new CourtHydratorFilter());
    }

}
