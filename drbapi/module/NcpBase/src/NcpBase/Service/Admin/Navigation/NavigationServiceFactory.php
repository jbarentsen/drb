<?php

namespace NcpBase\Service\Admin\Navigation;

use Zend\Navigation\Exception\InvalidArgumentException;
use Zend\Navigation\Service\AbstractNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class NavigationServiceFactory extends AbstractNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'default';
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return array
     * @throws InvalidArgumentException
     */
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {
            $configuration = $serviceLocator->get('Config');
            //$user = $serviceLocator->get('zfcuser_auth_service')->getIdentity();
            $user = null;

            if (!isset($configuration['navigation'])) {
                throw new InvalidArgumentException('Could not find navigation configuration key');
            }
            if (!isset($configuration['navigation'][$this->getName()])) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Failed to find a navigation container by the name "%s"',
                        $this->getName()
                    )
                );
            }

            $pages = $this->getPagesFromConfig($configuration['navigation'][$this->getName()]);
            /*
            if (!empty($user)) {
                $pages[] = array(
                    'label' => 'Profile',
                    'route' => 'identity',
                );
                $pages[] = array(
                    'label' => 'Logout',
                    'route' => 'logout',
                );
            } else {
                $pages[] = array(
                    'label' => 'Sign in',
                    'route' => 'login',
                );
            }
             */
            $this->pages = $this->preparePages($serviceLocator, $pages);
        }
        return $this->pages;
    }
}
