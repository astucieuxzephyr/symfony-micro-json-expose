<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * @author Koen Vinken <vinkenkoen@gmail.com>
 * Cette classe doit contenir 3 fonctions :
 * - registerBundles pour les bundles à utiliser
 * - configureRoutes pour les routes à utiliser
 * - configureContainer pour la config et les services
 *
 */
class MicroKernel extends Kernel
{
    use MicroKernelTrait;

    /*
     * {@inheritDoc}
     * Pour les bundles
     */
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            // to be able to use twig : don't forget the config in the framework key
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new AppBundle\AppBundle(),
            // bundles ajoutés via composer require
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),

            // bundle security pour la gestion de l'authentification et des droits/autorisations
            // pour permettre le fonctionnement de LexikJWTAuthenticationBundle
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            // Bundle permettant la sécurisation du JSON via un Token JWT
            new Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle(),
            // Bundle permettant l'authentification RESTful avec une clé API
            // new Ma27\ApiKeyAuthenticationBundle\Ma27ApiKeyAuthenticationBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();

        }

        return $bundles;
    }

    /*
     * {@inheritDoc}
     * Pour les routes
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $routes->mount('/_wdt', $routes->import('@WebProfilerBundle/Resources/config/routing/wdt.xml'));
            $routes->mount(
                '/_profiler',
                $routes->import('@WebProfilerBundle/Resources/config/routing/profiler.xml')
            );
        }

        $routes->mount('/', $routes->import('@AppBundle/Controller', 'annotation'));
        // $routes->import(__DIR__.'/../src/AppBundle/Controller', '/', 'annotation');

        // MODELE : $routes->add( 'chemin_de_route' ,'nom_du_controller' );
        // $routes->add('/', 'kernel:indexAction', 'index');
        // Route correspondant au controller situé plsu bas.
        $routes->add('/hello/symfony/{version}', 'kernel:helloSymfony');
    }

    /*
     * {@inheritDoc}
     * Pour charger la configuration et les services
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {

        // la configuration nous permet d'avoir TWIG et autres..
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');

        // $loader->load(__DIR__.'/config/services.yml'); // if you want to add services

    }

    public function helloSymfony($version)
    {
        return new Response('Hi Symfony version '.$version);
    }
}
