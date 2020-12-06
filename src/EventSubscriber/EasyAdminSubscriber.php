<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $appKernel;
    public function __construct (KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setIllustration'],
            BeforeEntityUpdatedEvent::class => ['updateIllustration']
        ];
    }

    public function imageSaver ($event)
    {
        $entity = $event->getEntityInstance();
        $tmp_name = $_FILES['Product']['tmp_name']['illustration']['file'];
        $filename = uniqid();
        $extension = pathinfo($_FILES['Product']['name']['illustration']['file'], PATHINFO_EXTENSION);
        $projectDir = $this->appKernel->getProjectDir();

        //dd($_FILES, $extension, $tmp_name, $projectDir.'/public/uploads/'.$filename.'.'.$extension);

        move_uploaded_file($tmp_name, $projectDir.'/public/uploads/'.$filename.'.'.$extension);
        $entity->setIllustration($filename.'.'.$extension);
    }
    public function updateIllustration(BeforeEntityUpdatedEvent $event)
    {
        if(!($event->getEntityInstance() instanceof Product))
        {
            return;
        }
        if ($_FILES['Product']['name']['illustration']['file'] != "")
        {
            $this->imageSaver($event);
        }
    }




    public function setIllustration(BeforeEntityPersistedEvent $event)
    {
        if(!($event->getEntityInstance() instanceof Product))
        {
            return;
        }
        $this->imageSaver($event);
    }
}