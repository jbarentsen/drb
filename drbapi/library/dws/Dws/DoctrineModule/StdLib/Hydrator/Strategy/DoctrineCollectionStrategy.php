<?php

namespace Dws\DoctrineModule\Stdlib\Hydrator\Strategy;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;
use Dws\Exception\InvalidArgumentException;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DoctrineCollectionStrategy extends AbstractCollectionStrategy
{
    /**
     * @var StrategyInterface
     */
    private $entityStrategy;

    /**
     * Constructor
     *
     * @param StrategyInterface $entityStrategy
     */
    public function __construct(StrategyInterface $entityStrategy)
    {
        $this->entityStrategy = $entityStrategy;
    }

    /**
     * {@inheritdoc}
     */
    public function extract($value)
    {
        if (!$value instanceof Collection) {
            throw new InvalidArgumentException(
                sprintf('Value to extract must be instance of Doctrine\Common\Collections\Collection, instance of \'%s\' given',
                    gettype($value)
                )
            );
        }

        $items = [];
        foreach ($value as $object) {
            $items[] = $this->entityStrategy->extract($object);
        }

        return $items;
    }

    /**
    * {@inheritdoc}
    */
    public function hydrate($value)
    {
        if (!$value instanceof Collection && !is_array($value)) {
            throw new InvalidArgumentException(
                sprintf('Value to hydrate must be instance of Doctrine\Common\Collections\Collection, instance of \'%s\' given',
                    gettype($value)
                )
            );
        }

        $items = new ArrayCollection();
        foreach ($value as $object) {
            $items->add($this->entityStrategy->hydrate($object));
        }

        return $items;
    }
}
