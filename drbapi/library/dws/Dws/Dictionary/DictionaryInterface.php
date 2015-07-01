<?php

namespace Dws\Dictionary;

/**
 * General interface for dictionary implementations
 */
interface DictionaryInterface
{

    /**
     * Return dictionary value for given identifier
     *
     * @param string $identifier
     *
     * @return string
     */
    public function get($identifier = '');

    /**
     * Return complete dictionary
     * @return string
     */
    public function getList();
}
