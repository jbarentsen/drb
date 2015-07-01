<?php

namespace NcpBase\Hydrator\Model;

use Doctrine\Common\Persistence\ObjectManager;
use Dws\DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use NcpBase\Hydrator\Filter\BaseHydratorFilter;
use Zend\Stdlib\Hydrator\NamingStrategy\UnderscoreNamingStrategy;

class BaseHydrator extends DoctrineHydrator
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ObjectManager $objectManager, $byValue = true)
    {
        parent::__construct($objectManager, $byValue);
        $this->setNamingStrategy(new UnderscoreNamingStrategy());

        $this->addFilter('main', new BaseHydratorFilter());
    }
}
