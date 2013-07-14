<?php

namespace Alex\WebBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Constraint locale of kernel requests.
 *
 * The defined locale must be one of given choices, otherwise it will
 * fallback to the first choice.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class LocaleListener implements EventSubscriberInterface
{
    /**
     * @var array
     */
    protected $locales;

    /**
     * @var string
     */
    protected $sessionKey;

    /**
     * Constructor.
     *
     * @param array  $locales    an array of strings (fr_FR, en_US, ...)
     * @param string $sessionKey set a session key to persist prefered choice in session
     */
    public function __construct(array $locales = array(), $sessionKey = null)
    {
        $this->locales = $locales;
        $this->sessionKey = $sessionKey;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => 'onRequest'
        );
    }

    /**
     * Filters the locale of a request.
     *
     * @param GetResponseEvent $event the event object
     */
    public function onRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($locale = $this->searchInQueryString($request)) {
            $this->saveLocale($request, $locale);
        } elseif ($locale = $this->searchInSession($request)) {

            // nothing to do
        } elseif ($locale = $this->searchInHeaders($request)) {
            $this->saveLocale($request, $locale);
        } elseif (false === empty($this->locales)) {
            $locale = $this->locales[0];
        } else {
            return;
        }

        $request->setLocale($locale);
    }

    /**
     * Searches a locale in session.
     *
     * @return string found locale
     */
    public function searchInSession(Request $request)
    {
        $session = $request->getSession();
        if (null === $session) {
            return;
        }

        return $session->get($this->sessionKey);
    }

    /**
     * Searches a locale in query-string (parameter _locale)
     *
     * @param Request $request the request to search in
     */
    protected function searchInQueryString(Request $request)
    {
        $locale = $request->query->get('_locale');

        if (!empty($this->locales) && !in_array($locale, $this->locales)) {
            return null;
        }

        return $locale;
    }

    /**
     * Searches a valid locale in HTTP headers.
     *
     * @param Request $request the request to search in
     *
     * @return string found locale
     */
    protected function searchInHeaders(Request $request)
    {
        if (empty($this->locales)) {
            return $request->getPreferredLanguage();
        }

        return $request->getPreferredLanguage($this->locales);
    }

    /**
     * Saves locale in session.
     *
     * @param Request $request the request to save locale in
     * @param string  $locale  the locale to set
     */
    protected function saveLocale(Request $request, $locale)
    {
        if (null === $this->sessionKey) {
            return;
        }

        $session = $request->getSession();
        if (null === $session) {
            throw new \RuntimeException('Listener is configured to persist locale in session but no session was found.');
        }

        $session->set($this->sessionKey, $locale);
    }
}
