<?php

namespace WordSelectorapp\DependencyInjection;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\Tools\Random;
use Silex\Application;
use Silex\ServiceProviderInterface;
use WordSelector\Entity\DoctrineWord;
use WordSelector\StoredWordSelector;
use WordSelectorApp\Controller\WordController;

/**
 * Class WordServiceProvider
 *
 * @package WordSelectorApp\DependencyInjection
 *
 * @codeCoverageIgnore
 */
class WordServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $config = json_decode(file_get_contents(__DIR__ . '/../../config/parameters.json'), true);

        $conn = $config["orm.doctrine.db"];
        $paths = $config["orm.doctrine.yml.paths"];
        $devMode = $config["orm.doctrine.devmode"];

        $app['entity.manager'] = $app->share(function () use ($conn, $paths, $devMode) {
            $config = Setup::createYAMLMetadataConfiguration($paths, $devMode);
            $config->addCustomNumericFunction('RANDOM', Random::class);
            return EntityManager::create($conn, $config);
        });

        $app['word.selector'] = $app->share(function () use ($app) {
            $repository = $app['entity.manager']->getRepository(DoctrineWord::class);
            return new StoredWordSelector($repository);
        });

        $app['word.controller'] = $app->share(function () use ($app) {
            return new WordController($app['word.selector']);
        });
    }

    public function boot(Application $app)
    {
    }
}
