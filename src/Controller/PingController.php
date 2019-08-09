<?php

declare(strict_types = 1);

namespace Free2er\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер проверки работоспособности API
 */
class PingController
{
    /**
     * Обрабатывает запрос
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return new JsonResponse(['ping' => $request->query->get('pong') ?: 'pong']);
    }
}
