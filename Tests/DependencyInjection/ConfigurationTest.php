<?php

namespace Alex\WebBundle\Tests\DependencyInjection;

use Alex\WebBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests when no configuration is provided for bundle.
     */
    public function testConfigurationNull()
    {
        $config = null;

        $expected = array(
            'locale_listener' => array(
                'enabled'     => false,
                'locales'     => array(),
                'session_key' => null,
            )
        );

        $this->assertEquals($expected, $this->normalizeValue($config));
    }

    public function getLocaleListener()
    {
        return array(
            array(null,  array('enabled' => true, 'locales' => array(), 'session_key' => '_alex_web_locale')),
            array(true,  array('enabled' => true,  'locales' => array(), 'session_key' => '_alex_web_locale')),
            array(false, array('enabled' => false, 'locales' => array(), 'session_key' => null)),
            array('fr_FR', array('enabled' => true, 'locales' => array('fr_FR'), 'session_key' => '_alex_web_locale')),
            array(array('fr_FR', 'en_US'), array('enabled' => true, 'locales' => array('fr_FR', 'en_US'), 'session_key' => '_alex_web_locale')),
            array(array('enabled' => true, 'locales' => array('fr_FR', 'en_GB'), 'session_key' => true), array('enabled' => true, 'locales' => array('fr_FR', 'en_GB'), 'session_key' => '_alex_web_locale')),
            array(array('enabled' => true, 'locales' => array('fr_FR', 'en_GB'), 'session_key' => false), array('enabled' => true, 'locales' => array('fr_FR', 'en_GB'), 'session_key' => null)),
        );
    }

    /**
     * @dataProvider getLocaleListener
     */
    public function testLocaleListener($configured, $expected)
    {
        $config = array('locale_listener' => $configured);
        $config = $this->normalizeValue($config);

        $this->assertEquals($expected, $config['locale_listener']);
    }

    private function normalizeValue($value)
    {
        $processor     = new Processor();

        return $processor->processConfiguration(new Configuration(), array($value));
    }
}
