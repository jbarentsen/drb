<?php

namespace DwsBase\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormRow as BaseFormRow;

class FormRowHelper extends BaseFormRow
{

    public function render(ElementInterface $element)
    {
        $inputErrorClass = '';

        // Does this element have errors ?
        if (count($element->getMessages()) > 0) {
            $inputErrorClass = ' has-error';
        }

        $type = $element->getAttribute('type');

        if ($type != 'checkbox') {
            return '<div class="form-group' . $inputErrorClass . '">' . parent::render($element) . '</div>';
        }

        $prefix = '<div class="form-group' . $inputErrorClass . '"><div class="col-sm-offset-2 col-sm-5"><div class="checkbox">';

        $postfix = '</div></div></div>';

        return $prefix . parent::render($element) . $postfix;
    }
}
