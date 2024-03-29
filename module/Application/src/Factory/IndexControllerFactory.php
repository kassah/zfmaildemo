<?php


namespace Application\Factory;
use Application\Controller\IndexController;
use Zend\Mail\Transport\Factory as MailTransportFactory;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;


class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return IndexController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $transport = $container->get(MailTransportFactory::class);
        $viewRenderer = $container->get('ViewRenderer');
        return new IndexController($transport, $viewRenderer);
    }
}