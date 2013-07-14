<?php

namespace Alex\WebBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AlexWebExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader->load('form.xml');
        $loader->load('kernel.xml');

        if ($config['locale_listener']['enabled']) {
            $container->setParameter('alex_web.locale_listener.locales', $config['locale_listener']['locales']);
            $container->setParameter('alex_web.locale_listener.session_key', $config['locale_listener']['session_key']);
        } else {
            $container->removeDefinition('alex_web.locale_listener');
        }
    }
}
