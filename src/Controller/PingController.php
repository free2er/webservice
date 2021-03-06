<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     *
     * @Route("/")
     */
    public function __invoke(Request $request): Response
    {
        return new JsonResponse([
            'message' => 'hello',
            'query'   => $request->query->all(),
            'request' => $request->request->all(),
        ]);
    }
}
