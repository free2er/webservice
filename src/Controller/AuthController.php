<?php

declare(strict_types = 1);

namespace Free2er\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер авторизации
 */
class AuthController
{
    /**
     * Обрабатывает запрос
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        return new JsonResponse(['access_token' => 'test']);
    }
}
