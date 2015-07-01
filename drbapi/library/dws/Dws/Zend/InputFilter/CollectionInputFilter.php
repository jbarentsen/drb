<?php

namespace Dws\Zend\InputFilter;

use Zend\InputFilter\CollectionInputFilter as BaseCollectionInputFilter;

class CollectionInputFilter extends BaseCollectionInputFilter
{
    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        $inputFilter = $this->getInputFilter();
        $valid = true;

        if ($this->getCount() < 1) {
            if ($this->isRequired) {
                $valid = false;
            }
        }

        if (is_scalar($this->data)
            || count($this->data) < $this->getCount()
        ) {
            $valid = false;
        }

        if (empty($this->data) || is_scalar($this->data)) {
            $this->clearValues();
            $this->clearRawValues();

            return $valid;
        }

        foreach ($this->data as $key => $data) {
            if (!is_array($data)) {
                if (is_int($data)) {
                    $data = array('id' => $data);
                } else {
                    $data = array();
                }
            }
            $inputFilter->setData($data);

            if (null !== $this->validationGroup) {
                $inputFilter->setValidationGroup($this->validationGroup[$key]);
            }

            if ($inputFilter->isValid()) {
                $this->validInputs[$key] = $inputFilter->getValidInput();
            } else {
                $valid = false;
                $this->collectionMessages[$key] = $inputFilter->getMessages();
                $this->invalidInputs[$key] = $inputFilter->getInvalidInput();
            }

            $this->collectionValues[$key] = $inputFilter->getValues();
            $this->collectionRawValues[$key] = $inputFilter->getRawValues();
        }

        return $valid;
    }

}