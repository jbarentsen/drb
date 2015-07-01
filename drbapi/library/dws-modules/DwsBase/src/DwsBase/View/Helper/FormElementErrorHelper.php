<?php

namespace DwsBase\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as BaseFormElementErrors;

class FormElementErrorHelper extends BaseFormElementErrors
{
    /*     * @+
     * @var string Templates for the open/close/separators for message tags
     */

    protected $messageCloseString = '</div>';
    protected $messageOpenFormat = '<div%s>';
    protected $messageSeparatorString = '<br/>';
    /*     * @- */

    /**
     * @var array Default attributes for the open format tag
     */
    protected $attributes = array(
        'class' => 'help-block'
    );
}
