<?php

namespace Korpus\LoggingBundle\Service;

use Korpus\LoggingBundle\Entity\AccessLog;
use Doctrine\ORM\EntityManager;

class AccessLogger {

    private $em;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function log($source_ip, $target_resource, $referer) {
        $accessLog = new AccessLog();

        $accessLog->setDate(new \DateTime('now'));
        $accessLog->setReferer($referer);
        $accessLog->setSourceIp(md5($source_ip));
        $accessLog->setTargetResource($target_resource);

        $this->em->persist($accessLog);
        $this->em->flush();
    }

}