<?php

namespace Alex\WebBundle\Tests\EventListener;

use Alex\WebBundle\EventListener\LocaleListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LocaleListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyChoiceNoSession()
    {
        // Through query string
        $event = $this->createEvent(array('_locale' => 'fr_FR'));
        $this->listenTo($event);
        $this->assertEquals('fr_FR', $event->getRequest()->getLocale());

        // Through headers
        $event = $this->createEvent(array(), array('Accept-Language' => 'fr_FR'));
        $this->listenTo($event);
        $this->assertEquals('fr_FR', $event->getRequest()->getLocale());
    }

    public function testSessionPersistence()
    {
        $event = $this->createEvent(array('_locale' => 'fr_FR'), array(), 'foo');
        $this->listenTo($event, array(), 'foo');
        $this->assertEquals('fr_FR', $event->getRequest()->getLocale());

        $event->getRequest()->query->remove('_locale');
        $event->getRequest()->setLocale('en_US');
        $this->listenTo($event, array(), 'foo');

        $this->assertEquals('fr_FR', $event->getRequest()->getLocale());
    }

    public function testAcceptLanguage()
    {
        $event = $this->createEvent(array(), array('Accept-Language' => 'fr_FR, en_US, fr_CA'));

        $this->listenTo($event);
        $this->assertEquals('fr_FR', $event->getRequest()->getLocale());

        $this->listenTo($event, array('fr_CA', 'en_US'));
        $this->assertEquals('en_US', $event->getRequest()->getLocale());

        $this->listenTo($event, array('en_GB'));
        $this->assertEquals('en_GB', $event->getRequest()->getLocale());
    }

    /**
     * Creates a LocaleListener with given configuration and dispatch event in it.
     *
     * @param GetResponseEvent $event      event to dispatch
     * @param array            $locales    locales to use for LocaleListener
     * @param string|null      $sessionKey sessionKey to pass to LocaleListener
     */
    private function listenTo(GetResponseEvent $event, array $locales = array(), $sessionKey = null)
    {
        $listener = new LocaleListener($locales, $sessionKey);
        $listener->onRequest($event);
    }

    /**
     * Creates an event object for the test of LocaleListener.
     *
     * @param array   $query    an array of query parameters for URL
     * @param array   $headers  HTTP headers to request
     * @param boolean $session  creates a session in the request
     *
     * @return GetResponseEvent
     */
    private function createEvent(array $query = array(), array $headers = array(), $session = false)
    {
        $kernel = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');

        $kernel->handle(new Request());
        $request = new Request($query);
        $request->headers->add($headers);

        if ($session) {
            $session = new Session(new MockArraySessionStorage());
            $request->setSession($session);
        }

        return new GetResponseEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST);
    }
}
