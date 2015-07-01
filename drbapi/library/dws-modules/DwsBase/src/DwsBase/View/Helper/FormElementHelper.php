<?php

namespace DwsBase\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElement as BaseFormElement;

class FormElementHelper extends BaseFormElement
{

    public function render(ElementInterface $element)
    {
        $attributes = $element->getAttributes();
        if (isset($attributes['custom'])) {
            $custom = $attributes['custom'];
            unset($attributes['custom']);
            $element->setAttributes($attributes);
        }
        $prefix = '';
        $suffix = '';

        // Check on name for now
        if ($attributes['type'] === 'text' && $attributes['name'] === 'email') {
            $prefix .= '<div class="input-group">';
            $prefix .= '<span class="input-group-addon">@</span>';
            $suffix .= '<span class="input-group-addon" id="basic-addon2">@example.com</span>';
            $suffix .= '</div>';
        } elseif ($attributes['type'] === 'text' && $attributes['name'] === 'keyword') {
            $prefix .= '<div class="input-group">';
            $suffix .= '<span class="input-group-btn">';
            $suffix .= sprintf('<button class="btn btn-default" type="submit">%s</button>', $custom['label']);
            $suffix .= '</span>';
        }
        return $prefix . parent::render($element) . $suffix;
    }
}
