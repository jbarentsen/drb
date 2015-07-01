<?php

namespace NcpBase\Hydrator\Strategy;

use NcpBase\Hydrator\Model\BaseHydrator;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class BaseHydratorStrategy implements StrategyInterface
{
    /**
     * @var BaseHydrator
     */
    private $baseHydrator;

    /**
     * @var string
     */
    private $modelName;

    /**
     * Constructor
     *
     * @param BaseHydrator $baseHydrator
     * @param string $modelName
     */
    public function __construct(BaseHydrator $baseHydrator, $modelName)
    {
        $this->baseHydrator = $baseHydrator;
        $this->modelName = $modelName;
    }

    /**
     * {@inheritdoc}
     */
    public function extract($value)
    {
        if (is_array($value)) {
            return $value;
        }

        return $this->baseHydrator->extract($value);
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($value)
    {
        if (is_object($value)) {
            return $value;
        }

        return $this->baseHydrator->hydrate($value, new $this->modelName());
    }
}
