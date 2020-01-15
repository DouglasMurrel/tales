<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

use Psr\Log\LoggerInterface;

class RequestSubscriber implements EventSubscriberInterface
{
    use TargetPathTrait;

    private $session;

    private $logger;

    public function __construct(SessionInterface $session, LoggerInterface $myLogger)
    {
        $this->session = $session;
        $this->logger = $myLogger;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (!$event->isMasterRequest() || $request->isXmlHttpRequest()) {
            return;
        }

        $this->logger->debug("RequestSubscr");

        $uri = $request->getUri();
        if(!preg_match('/\/login$/',$uri) && !preg_match('/\/logout$/',$uri)) {
            $this->saveTargetPath($this->session, 'main', $uri);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest']
        ];
    }
}
?>