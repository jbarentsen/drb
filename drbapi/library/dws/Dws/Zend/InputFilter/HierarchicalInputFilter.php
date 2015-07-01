<?php

namespace Dws\Zend\InputFilter;

use Dws\Exception\InvalidArgumentException;
use Dws\Utils;
use stdClass;
use Traversable;
use Zend\InputFilter\InputFilter as BaseInputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception;

class HierarchicalInputFilter extends BaseInputFilter
{
    /**
     * @var InputFilterInterface[]
     */
    private $nestedInputFilters = [];

    /**
     * @param string $name
     * @param BaseInputFilter $nestedInputFilter
     * @return HierarchicalInputFilter
     */
    public function addNested($name, BaseInputFilter $nestedInputFilter)
    {
        $this->nestedInputFilters[$name] = $nestedInputFilter;

        return $this;
    }

    /**
     * @param string $name
     * @return HierarchicalInputFilter
     */
    public function removeNestedInputFilter($name)
    {
        if (isset($this->nestedInputFilters[$name])) {
            unset($this->nestedInputFilters[$name]);
        }

        return $this;
    }

    /**
     * @param array|stdClass|Traversable $data
     * @return HierarchicalInputFilter
     * @throws InvalidArgumentException
     */
    public function setData($data)
    {
        if ($data instanceof stdClass) {
            $data = Utils::toArray($data);
        }

        // set data and prevent validation of (arrays of) objects by removing the nested input filter
        // note: the actual input filter is not removed because otherwise there would be no container
        //       for the data. setting the input filter to not required is also not necessary because
        //       the data is already set so it's always valid.
        foreach ($this->nestedInputFilters as $name => $nestedInputFilter) {
            if (isset($data[$name])) {
                if (is_object($data[$name]) ||
                   (is_array($data[$name]) && (
                       $this->isContainingObjects($data[$name]) ||
                       (isset($data[$name]['id']) ||
                       (isset($data[$name][0]) && isset($data[$name][0]['id'])))
                   ))
                ) {
                    $this->removeNestedInputFilter($name);
                } else {
                    $nestedInputFilter->setData($data[$name]);
                }
            } else {
                $nestedInputFilter->setData([]);
            }
        }

        parent::setData($data);

        return $this;
    }

    /**
     * @param array $array
     * @return bool
     */
    private function isContainingObjects(array &$array)
    {
        foreach ($array as $item) {
            if (!is_object($item)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        $values = parent::getValues();

        foreach ($this->nestedInputFilters as $name => $nestedInputFilter) {
            $values += [
                $name => $nestedInputFilter->getValues()
            ];
        }

        return $values;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        $messages = parent::getMessages();

        foreach ($this->nestedInputFilters as $name => $nestedInputFilter) {
            $messages += [
                $name => $nestedInputFilter->getMessages()
            ];
        }

        return $messages;
    }

    /**
     * @param  mixed|null $context
     * @return bool
     */
    public function isValid($context = null)
    {
        $result = parent::isValid($context);

        if ($result === true) {
            foreach ($this->nestedInputFilters as $name => $nestedInputFilter) {
//                if (is_int($this->getValue($name))) {
//                    continue;
//                }
                $nestedResult = $nestedInputFilter->isValid($context);
                if (!$nestedResult) {
                    $result = false;
                }
            }
        }

        return $result;
    }
}
