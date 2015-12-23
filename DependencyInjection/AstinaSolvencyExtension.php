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

        $provider = $config['provider'];
        if (isset($provider['deltavista'])) {

            $loader->load('provider/deltavista.xml');
            foreach (array('wsdl_url', 'user', 'password', 'correlation_id', 'endpoint_url') as $param) {
                if (isset($provider['deltavista'][$param])) {
                    $container->setParameter('astina_solvency.provider.deltavista.' . $param, $provider['deltavista'][$param]);
                }
            }

            $definition = $container->getDefinition('astina_solvency.provider');
            $definition->replaceArgument(0, $container->getDefinition('astina_solvency.provider.deltavista'));

        } elseif (isset($provider['mock'])) {

            $loader->load('provider/mock.xml');
            if (isset($provider['mock']['status'])) {
                $container->setParameter('astina_solvency.provider.mock.status', $provider['mock']['status']);
            }

            $definition = $container->getDefinition('astina_solvency.provider');
            $definition->replaceArgument(0, $container->getDefinition('astina_solvency.provider.mock'));
        } elseif (isset($provider['intrum'])) {

            $loader->load('provider/intrum.xml');
            foreach (array('user_id', 'client_id', 'client_email', 'password', 'endpoint_url') as $param) {
                if (isset($provider['intrum'][$param])) {
                    $container->setParameter('astina_solvency.provider.intrum.' . $param, $provider['intrum'][$param]);
                }
            }

            $definition = $container->getDefinition('astina_solvency.provider');
            $definition->replaceArgument(0, $container->getDefinition('astina_solvency.provider.intrum'));

        }
    }
}
