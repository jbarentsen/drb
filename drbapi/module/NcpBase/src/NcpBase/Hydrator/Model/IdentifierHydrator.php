<?php

namespace NcpBase\Hydrator\Model;

use Doctrine\Common\Persistence\ObjectManager;
use NcpBase\Hydrator\Filter\IdentifierHydratorFilter;

class IdentifierHydrator extends BaseHydrator
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ObjectManager $objectManager, $byValue = true)
    {
        parent::__construct($objectManager, $byValue);

        $this->addFilter('main', new IdentifierHydratorFilter());
    }
}
