<?php


namespace Application\Factory;
use Interop\Container\ContainerInterface;

use Zend\Mail\Transport\Factory as ZendMailFactory;
use Zend\Mail\Transport\TransportInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class MailTransportServiceFactory extends ZendMailFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return TransportInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Take config
        $config = $container->has('config') ? $container->get('config') : [];
        $mailConfig = isset($config['mail']) ? $config['mail'] : [];
        $transportConfig = isset($mailConfig['transport']) ? $mailConfig['transport'] : [];

        // and inject it into the abstract factory "create" function.
        return $this->create($transportConfig);
    }
}