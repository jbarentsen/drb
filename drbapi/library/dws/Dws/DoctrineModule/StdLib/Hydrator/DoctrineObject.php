<?php

namespace Dws\DoctrineModule\Stdlib\Hydrator;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as BaseDoctrineObject;
use Dws\DoctrineModule\Stdlib\Hydrator\Strategy\DoctrineCollectionStrategy;
use Zend\Filter\Word\UnderscoreToCamelCase;

class DoctrineObject extends BaseDoctrineObject
{
    /**
     * @var UnderscoreToCamelCase
     */
    private $wordFilter;

    /**
     * {@inheritdoc}
     */
    public function __construct(ObjectManager $objectManager, $byValue = true)
    {
        parent::__construct($objectManager, $byValue);

        $this->wordFilter = new UnderscoreToCamelCase();
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate(array $data, $object)
    {
        // get collection properties
        $collectionProperties = [];
        foreach ($data as $name => $values) {
            $computedFieldName = $this->computeHydrateFieldName($name);
            if ($this->hasStrategy($computedFieldName) && $this->getStrategy($computedFieldName) instanceof DoctrineCollectionStrategy) {
                $collectionProperties[$computedFieldName] = $values;
                unset($data[$name]);
            }
        }

        // hydrate object
        $object = parent::hydrate($data, $object);

        // hydrate collection properties using strategies
        foreach ($collectionProperties as $name => $collectionValues) {
            $method = 'set' . ucfirst($name);
            $object->$method($this->getStrategy($name)->hydrate($collectionValues));
        }

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function extract($object)
    {
        // extract object
        $array = parent::extract($object);

        // extract collection properties using strategies
        foreach ($array as $name => $values) {
            $computedFieldName = $this->computeHydrateFieldName($name);
            if ($this->hasStrategy($computedFieldName)) {
                $method = 'get' . ucfirst($computedFieldName);
                $array[$name] = $this->getStrategy($computedFieldName)->extract($object->$method());
            }
        }

        return $array;
    }
}
