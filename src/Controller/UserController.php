<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Контроллер проверки аутентификации
 */
class UserController
{
    /**
     * Обрабатывает запрос
     *
     * @param UserInterface $user
     *
     * @return Response
     */
    public function __invoke(UserInterface $user): Response
    {
        return new JsonResponse(['user' => $user->getUsername()]);
    }
}
