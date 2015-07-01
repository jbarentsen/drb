<?php

namespace NcpBase\Hydrator\Strategy;

use NcpBase\Hydrator\Model\IdentifierHydrator;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class IdentifierHydratorStrategy implements StrategyInterface
{
    /**
     * @var IdentifierHydrator
     */
    private $identifierHydrator;

    /**
     * @var string
     */
    private $modelName;

    /**
     * Constructor
     *
     * @param IdentifierHydrator $identifierHydrator
     * @param string $modelName
     */
    public function __construct(IdentifierHydrator $identifierHydrator, $modelName)
    {
        $this->identifierHydrator = $identifierHydrator;
        $this->modelName = $modelName;
    }

    /**
     * {@inheritdoc}
     */
    public function extract($value)
    {
        if (is_array($value) || is_null($value)) {
            return $value;
        }

        return $this->identifierHydrator->extract($value);
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($value)
    {
        if (is_object($value)) {
            return $value;
        }

        return $this->identifierHydrator->hydrate($value, new $this->modelName());
    }
}
