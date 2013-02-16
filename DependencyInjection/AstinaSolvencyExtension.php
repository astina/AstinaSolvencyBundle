<?php

namespace Astina\Bundle\SolvencyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AstinaSolvencyExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (isset($config['deltavista'])) {
            $loader->load('provider/deltavista.xml');
            foreach (array('wsdl_url', 'user', 'password', 'correlation_id', 'endpoint_url') as $param) {
                if (isset($config['deltavista'][$param])) {
                    $container->setParameter('astina_solvency.provider.' . $param, $config['deltavista'][$param]);
                }
            }
        } elseif (isset($config['mock'])) {
            $loader->load('provider/mock.xml');
            if (isset($config['mock']['status'])) {
                $container->setParameter('astina_solvency.provider.status', $config['mock']['status']);
            }
        }
    }
}
