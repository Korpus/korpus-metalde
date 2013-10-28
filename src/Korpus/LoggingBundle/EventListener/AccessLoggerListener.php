<?php

namespace Korpus\LoggingBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class AccessLoggerListener
{

    private $service_container;

    public function __construct(ContainerInterface $service_container)
    {
        $this->service_container = $service_container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            // don't do anything if it's not the master request
            return;
        }

        //get the logger service
        $logger = $this->service_container->get('korpus.service.accesslogger');

        $request = $event->getRequest();

        $source_ip = $request->server->get('REMOTE_ADDR');
        $target_resource = $request->server->get('REQUEST_URI');
        $referer = ($request->server->get('HTTP_REFERER') == null ? '' : $request->server->get('HTTP_REFERER'));

        $logger->log($source_ip, $target_resource, $referer);
    }

}