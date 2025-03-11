<?php

namespace App;

use App\Middleware\ApiKeyMiddleware;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Kernel extends BaseKernel implements EventSubscriberInterface
{
    use MicroKernelTrait;

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        (new ApiKeyMiddleware())($event);
    }
}
