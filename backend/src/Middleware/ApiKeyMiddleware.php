<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ApiKeyMiddleware
{
    private const API_KEY = 'd8aa3cc84418f09f1257c42cd8118a746cc2b7314310bc55f70562dd3e725c57'; // Remplacez par votre clé API

    public function __invoke(RequestEvent $event)
    {
        $request = $event->getRequest();

        // Vérifiez si la route commence par /api/public
        if (strpos($request->getPathInfo(), '/api/public') === 0) {
            $apiKey = $request->headers->get('x-api-key');

            if ($apiKey !== self::API_KEY) {
                throw new AccessDeniedHttpException('Clé API invalide.');
            }
        }
    }
} 