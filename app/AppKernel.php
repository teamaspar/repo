<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;


class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new BeSimple\I18nRoutingBundle\BeSimpleI18nRoutingBundle(),
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Oneup\UploaderBundle\OneupUploaderBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),
            new Hampe\Bundle\ZurbInkBundle\HampeZurbInkBundle(),
            new ApiPlatform\Core\Bridge\Symfony\Bundle\ApiPlatformBundle(),
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new FM\ElfinderBundle\FMElfinderBundle(),
            new AppBundle\AppBundle(),
            new MotogpBundle\MotogpBundle(),
            new \EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->setParameter('container.autowiring.strict_mode', true);
            $container->setParameter('container.dumper.inline_class_loader', true);

            $container->addObjectResource($this);
        });
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
