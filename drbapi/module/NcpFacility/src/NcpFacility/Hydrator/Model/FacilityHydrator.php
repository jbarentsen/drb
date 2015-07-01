<?php

namespace NcpFacility\Hydrator\Model;

use Doctrine\Common\Persistence\ObjectManager;
use NcpBase\Hydrator\Filter\BaseHydratorFilter;
use NcpBase\Hydrator\Model\BaseHydrator;
use NcpBase\Hydrator\Strategy\BaseHydratorStrategy;

class FacilityHydrator extends BaseHydrator
{
    /**
     * Constructor
     *
     * @param BaseHydrator $baseHydrator
     * @param ObjectManager $objectManager
     * @param bool $byValue
     */
    public function __construct(
        BaseHydrator $baseHydrator,
        ObjectManager $objectManager,
        $byValue = true
    ) {
        parent::__construct($objectManager, $byValue);

        $this->addFilter('main', new BaseHydratorFilter());

        $baseStrategy = new BaseHydratorStrategy($baseHydrator, 'NcpFacility\Model\Facility\FacilityAddress');
        $this->addStrategy('address', $baseStrategy);
    }
}