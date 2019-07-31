<?php


namespace Application\Factory;
use Application\Mail\Transport\MailgunTransport;
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
        $transportType = isset($transportConfig['type']) ? $transportConfig['type'] : null;

        // Due to lack of flexibility in the abstract Factory, injecting mailgun config here.
        if ($transportType == 'mailgun') {
            $mailgunConfig = isset($transportConfig['options']) ? $transportConfig['options'] : [];

            $domain = isset($mailgunConfig['domain']) ? $mailgunConfig['domain'] : '';
            $apiKey = isset($mailgunConfig['api_key']) ? $mailgunConfig['api_key'] : '';
            $toOverride = isset($mailgunConfig['to']) ? $mailgunConfig['to'] : '';
            $from = isset($mailgunConfig['from']) ? $mailgunConfig['from'] : '';
            return new MailgunTransport($domain, $apiKey, $toOverride, $from);
        }

        // and inject it into the abstract factory "create" function.
        return $this->create($transportConfig);
    }
}