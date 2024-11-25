<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiUserChecker implements UserCheckerInterface
{
    /**
     * Vérifie si l'utilisateur est autorisé à accéder à l'API avant l'authentification.
     *
     * @param UserInterface $user : L'utilisateur à vérifier avant l'authentification.
     */
    public function checkPreAuth(UserInterface $user): void
    {
        // On vérifie si l'utilisateur est une instance de la classe User.
        if ($user instanceof User && !$user->isApiAccessEnabled()) {
            // Si l'utilisateur n'a pas l'accès API activé, on lève une exception AccessDeniedException.
            throw new AccessDeniedException('L\'accès API n\'est pas activé pour cet utilisateur.');
        }
    }

    /**
     * Méthode appelée après l'authentification de l'utilisateur.
     *
     * @param UserInterface $user : L'utilisateur authentifié.
     */
    public function checkPostAuth(UserInterface $user): void
    {
        // Aucune vérification après authentification complète nécessaire ici.
    }
}
