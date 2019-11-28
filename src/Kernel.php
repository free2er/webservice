<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Throwable;

/**
 * Ядро приложения
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * Допустимые расширения файлов конфигурации
     *
     * @const string
     */
    private const EXT = '.{php,xml,yaml,yml}';

    /**
     * Возвращает корневую директорию приложения
     *
     * @return string
     */
    public function getProjectDir(): string
    {
        return dirname(__DIR__);
    }

    /**
     * Регистрирует модули приложения
     *
     * @return iterable
     */
    public function registerBundles(): iterable
    {
        $confDir = $this->getProjectDir() . '/config';
        $env     = $this->getEnvironment();

        $bundles = require $confDir . '/bundles.php';

        foreach ($bundles as $bundle => $envs) {
            if ($envs[$env] ?? $envs['all'] ?? false) {
                yield new $bundle();
            }
        }
    }

    /**
     * Устанавливает параметры сервис-контейнера
     *
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     *
     * @throws Throwable
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $confDir = $this->getProjectDir() . '/config';
        $env     = $this->getEnvironment();

        $container->addResource(new FileResource($confDir . '/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', !ini_get('opcache.preload'));
        $container->setParameter('container.dumper.inline_factories', true);

        $loader->load($confDir . '/{packages}/*' . self::EXT, 'glob');
        $loader->load($confDir . '/{packages}/' . $env . '/*' . self::EXT, 'glob');
        $loader->load($confDir . '/{services}' . self::EXT, 'glob');
        $loader->load($confDir . '/{services}_' . $env . self::EXT, 'glob');
    }

    /**
     * Устанавливает параметры маршрутизатора
     *
     * @param RouteCollectionBuilder $routes
     *
     * @throws Throwable
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir() . '/config';
        $env     = $this->getEnvironment();

        $routes->import($confDir . '/{routes}/' . $env . '/*' . self::EXT, '/', 'glob');
        $routes->import($confDir . '/{routes}/*' . self::EXT, '/', 'glob');
        $routes->import($confDir . '/{routes}' . self::EXT, '/', 'glob');
    }
}
