<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleListener implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        //Define french if user's preferred language is french
        $request->setLocale(strpos($request->getPreferredLanguage(), 'fr') === false ? $this->defaultLocale : 'fr' );

        //Define locale in the session
        $request->getSession()->set('_locale', strpos($request->getPreferredLanguage(), 'fr') === false ? $this->defaultLocale : 'fr' );

    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
        );
    }
}
