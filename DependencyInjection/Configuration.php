<?php

namespace Alex\WebBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $builder->root('alex_web')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('locale_listener')
                    ->addDefaultsIfNotSet()
                    ->treatNullLike(array('enabled' => true, 'session_key' => true))
                    ->treatTrueLike(array('enabled' => true, 'session_key' => true))
                    ->treatFalseLike(array('enabled' => false))
                    ->beforeNormalization()
                        ->always(function ($value) {
                            if (is_string($value)) {
                                return array('enabled' => true, 'locales' => array($value), 'session_key' => true);
                            }

                            if (!is_array($value)) {
                                return $value;
                            }

                            // don't filter if array has a string as key
                            foreach (array_keys($value) as $key) {
                                if (is_string($key)) {
                                    return $value;
                                }
                            }

                            // assume it's a list of cultures
                            return array('enabled' => true, 'locales' => $value, 'session_key' => true);
                        })
                    ->end()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->arrayNode('locales')
                            ->useAttributeAsKey('key')
                            ->addDefaultChildrenIfNoneSet(array())
                            ->treatNullLike(array())
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('session_key')
                            ->defaultValue(null)
                            ->treatFalseLike(null)
                            ->treatTrueLike('_alex_web_locale')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}
