<?php

/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2014 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\DependencyInjection;

use PommProject\Foundation\Pomm;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * PommExtension
 *
 * DIC extension
 *
 * @package PommBundle
 * @copyright 2014 Grégoire HUBERT
 * @author Nicolas JOSEPH
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see Extension
 */
class PommExtension extends Extension
{
    /**
     * load
     *
     * @throws \Exception
     * @see Extension
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services/pomm.yml');
        $loader->load('services/profiler.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->configure($config, $container);
    }

    /**
     * configure
     *
     * Configure the DIC using configuration file.
     *
     * @access public
     * @param array $config
     * @param ContainerBuilder $container
     * @return void
     */
    public function configure(array $config, ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('pomm');

        $container->setAlias(Pomm::class, new Alias('pomm', false));
        $container->setParameter('pomm.configuration', $config['configuration']);

        if (isset($config['logger']['service'])) {
            $service = $config['logger']['service'];

            if (is_string($service) && str_starts_with($service, '@')) {
                $definition
                    ->addMethodCall('setLogger', [new Reference(substr($service, 1))]);
            }
        }
    }
}
