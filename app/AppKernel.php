<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Korpus\MainPageBundle\KorpusMainPageBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Korpus\UserBundle\KorpusUserBundle(),
            new Korpus\ConsoleBundle\KorpusConsoleBundle(),
            new Korpus\DataBundle\KorpusDataBundle(),
            new Korpus\HelperBundle\KorpusHelperBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Korpus\FileServerBundle\KorpusFileServerBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Korpus\LoggingBundle\KorpusLoggingBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Korpus\BackupBundle\KorpusBackupBundle(),
            new Korpus\EventsBundle\KorpusEventsBundle(),
            new Korpus\EmailBundle\KorpusEmailBundle(),
            new Korpus\AdminPanelBundle\KorpusAdminPanelBundle(),
            new Korpus\TwigBundle\KorpusTwigBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}
