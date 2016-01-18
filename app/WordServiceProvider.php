<?php
namespace WordSelectorApp;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class WordServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['dependency.injector'] = $app->share(function () {
            $containerBuilder = new ContainerBuilder();
            $loader = new YamlFileLoader(
                $containerBuilder,
                new FileLocator(__DIR__ . '/../config')
            );
            $loader->load('application.yml');

            return $containerBuilder;
        });

        $app['word.controller'] = $app->share(function () use ($app) {
            return new WordController($app['dependency.injector']->get('WordSelector'));
        });
    }

    public function boot(Application $app)
    {
    }
}
