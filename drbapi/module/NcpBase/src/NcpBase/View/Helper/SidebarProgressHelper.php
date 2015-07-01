<?php

namespace NcpBase\View\Helper;

use NcpBase\View\Helper\Progress\ProgressInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\HelperInterface;

class SidebarProgress extends AbstractHelper implements HelperInterface
{
    /**
     *
     * @var ProgressInterface
     */
    private $progress;

    /**
     *
     * @param ProgressInterface $progress
     * @return string
     */
    public function __invoke(ProgressInterface $progress)
    {
        $this->progress = $progress;
        $structure = $this->progress->getStructure();

        $tree = '<ul>';
        foreach ($structure as $section) {
            $tree .= sprintf('<li class="%s">%s<ul>', $section['state'], $section['label']);
            foreach ($section['children'] as $child) {
                $tree .= sprintf('<li class="%s">%s</li>', $child['state'], $child['label']);
            }
            $tree .= '</ul></li>';
        }
        $tree .= '</ul>';
        return sprintf('<div class="sidebar-progress">%s</div>', $tree);
    }
}
