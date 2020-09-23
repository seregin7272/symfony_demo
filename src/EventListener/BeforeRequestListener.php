<?php


namespace App\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class BeforeRequestListener
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public function onKernelRequest(RequestEvent $event)
    {
        $filter = $this->em
            ->getFilters()
            ->enable('fortune_cookie_discontinued');
        $filter->setParameter('discontinued', false);
    }
}
