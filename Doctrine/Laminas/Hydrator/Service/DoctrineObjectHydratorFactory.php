<?php

declare(strict_types=1);

namespace Doctrine\Laminas\Hydrator\Service;

use Doctrine\Laminas\Hydrator\XDoctrineObject;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class DoctrineObjectHydratorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new XDoctrineObject($container->get('doctrine.entitymanager.orm_default'));
    }

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container->getServiceLocator(), XDoctrineObject::class);
    }
}
