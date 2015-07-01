<?php

namespace Dws;

use Dws\Dictionary\DictionaryInterface;

/**
 * Dictionary implementation for list of Countries
 */
class Countries implements DictionaryInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($identifier = '')
    {
        return $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getList()
    {
        return array(
            'aus' => 'Australia',
            'nze' => 'New Zealand',
        );
    }
}
