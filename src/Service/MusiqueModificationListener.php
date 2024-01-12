<?php
namespace App\Service;

use App\Entity\Musique;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

class MusiqueModificationListener
{
    private NotifierInterface $notifier;

    public function __construct(NotifierInterface $notifier)
    {
        $this->notifier = $notifier;
    }

    public function postUpdate(Musique $musique, LifecycleEventArgs $event): void
    {
        $changeSet = $event->getEntityManager()->getUnitOfWork()->getEntityChangeSet($musique);
        if (!empty($changeSet)) {
            $notification = new Notification('La musique a été modifiée avec succès.');
            $recipient = new Recipient('thomas.cheio@efrei.net');
            $this->notifier->send($notification, $recipient);
            $this->logNotification($notification);
        }
    }

    private function logNotification(Notification $notification): void
    {
        dump('Notification envoyée: ' . $notification->getSubject());
    }
}

?>