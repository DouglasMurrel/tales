<?php
namespace App\Form\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Psr\Log\LoggerInterface;

class FormEventSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $myLogger)
    {
        $this->logger = $myLogger;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        ];
    }

    public function onPreSetData(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();

        $this->logger->debug("FormEventSubscr");
    }

    public function onPreSubmit(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();
    }
}

?>