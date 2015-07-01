<?php

namespace Dws\Doctrine\ORM\Mapping;

use Doctrine\ORM\Mapping\DefaultNamingStrategy;

/**
 * Class DwsNamingStrategy
 */
class DwsNamingStrategy extends DefaultNamingStrategy
{
    public static $generatedNames = [];

    /**
     * {@inheritdoc}
     */
    public function classToTableName($className)
    {
        $classNameParts = $this->getClassNameParts($className);
        return $classNameParts['namespace'] . '_' . $classNameParts['className'];
    }

    /**
     * {@inheritdoc}
     */
    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null)
    {
        $sourceEntityClassNameParts = $this->getClassNameParts($sourceEntity);
        $targetEntityClassNameParts = $this->getClassNameParts($targetEntity);

        $name = substr(
            $sourceEntityClassNameParts['namespace'] . '_' .
            $sourceEntityClassNameParts['className'] . '_' .
            $targetEntityClassNameParts['className'],
            0,
            64
        );

        self::$generatedNames[$name] = (isset(self::$generatedNames[$name])) ?
            self::$generatedNames[$name] + 1 : 1;

        if (self::$generatedNames[$name] > 1) {
            $postfix = self::$generatedNames[$name];
            return substr($name, 0, 64 - strlen($postfix)) . $postfix;
        }

        return $name;
    }

    /**
     * {@inheritdoc}
     */
    public function joinKeyColumnName($entityName, $referencedColumnName = null)
    {
        $classNameParts = $this->getClassNameParts($entityName);
        return strtolower($classNameParts['className']{0}) .
            substr($classNameParts['className'], 1) . '_' .
            ($referencedColumnName ?: $this->referenceColumnName());
    }

    /**
     * Helper function to get the namespace and class name
     *
     * @param $className
     * @return array
     */
    private function getClassNameParts($className)
    {
        $classNameParts = explode('\\', $className);
        $previousClassNamePart = null;
        for ($i = 0; $i < count($classNameParts); $i++) {
            if (!empty($previousClassNamePart) && $this->endsWith($previousClassNamePart, $classNameParts[$i])) {
                unset($classNameParts[$i]);
                continue;
            }
            if ($classNameParts[$i] === 'Model' || $classNameParts[$i] === 'Entity') {
                unset($classNameParts[$i]);
                continue;
            }
            $previousClassNamePart = $classNameParts[$i];
        }
        $shortClassName = array_pop($classNameParts);

        return [
            'namespace' => implode('', $classNameParts),
            'className' => $shortClassName
        ];
    }

    /**
     * Helper function to check if a string ends with another string
     *
     * @param $haystack
     * @param $needle
     * @return bool
     */
    private function endsWith($haystack, $needle)
    {
        return $needle === '' || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
}
