<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class ApiAccessDeniedListener
{
    /**
     * Cette méthode écoute les exceptions de l'application.
     *
     * @param ExceptionEvent $event : L'événement d'exception contenant l'exception qui a été levée.
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        // On récupère l'exception qui a été lancée lors du traitement de la requête.
        $exception = $event->getThrowable();

        // On vérifie si l'exception est de type AccessDeniedException (accès non autorisé).
        if ($exception instanceof AccessDeniedException) {
            // On crée une réponse JSON personnalisée avec un code HTTP 403 (Forbidden).
            $response = new JsonResponse([
                'code' => 403,
                'message' => $exception->getMessage(),
            ], 403);

            // On remplace la réponse de l'événement par notre réponse personnalisée.
            $event->setResponse($response);
        }
    }
}
